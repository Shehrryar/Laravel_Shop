import json
from collections import Counter
from datetime import datetime

import pandas as pd
import torch
import torch.nn as nn
from sklearn.metrics import accuracy_score, classification_report
from torch.utils.data import Dataset, DataLoader

from src.config import (
    BATCH_SIZE,
    EPOCHS,
    LABELS_PATH,
    LEARNING_RATE,
    MODEL_DIR,
    MODEL_PATH,
    TEST_CSV,
    TRAIN_CSV,
    TRAINING_LOG_PATH,
    VOCAB_PATH,
)
from src.model import ShopIntentGRU, build_vocab, encode_text


DEVICE = "cuda" if torch.cuda.is_available() else "cpu"


class IntentDataset(Dataset):
    def __init__(self, texts, labels, vocab, label_to_id):
        self.texts = texts
        self.labels = labels
        self.vocab = vocab
        self.label_to_id = label_to_id

    def __len__(self):
        return len(self.texts)

    def __getitem__(self, index):
        input_ids = encode_text(self.texts[index], self.vocab)
        label_id = self.label_to_id[self.labels[index]]

        return {
            "input_ids": torch.tensor(input_ids, dtype=torch.long),
            "label": torch.tensor(label_id, dtype=torch.long),
        }


def write_log(text):
    with open(TRAINING_LOG_PATH, "a", encoding="utf-8") as file:
        file.write(text + "\n")


def main():
    MODEL_DIR.mkdir(parents=True, exist_ok=True)
    TRAINING_LOG_PATH.parent.mkdir(parents=True, exist_ok=True)

    if TRAINING_LOG_PATH.exists():
        TRAINING_LOG_PATH.unlink()

    train_df = pd.read_csv(TRAIN_CSV).dropna()
    test_df = pd.read_csv(TEST_CSV).dropna()

    train_texts = train_df["text"].astype(str).tolist()
    train_labels = train_df["intent"].astype(str).tolist()

    test_texts = test_df["text"].astype(str).tolist()
    test_labels = test_df["intent"].astype(str).tolist()

    vocab = build_vocab(train_texts)

    unique_labels = sorted(list(set(train_labels + test_labels)))
    label_to_id = {label: idx for idx, label in enumerate(unique_labels)}
    id_to_label = {idx: label for label, idx in label_to_id.items()}

    train_dataset = IntentDataset(train_texts, train_labels, vocab, label_to_id)
    test_dataset = IntentDataset(test_texts, test_labels, vocab, label_to_id)

    train_loader = DataLoader(train_dataset, batch_size=BATCH_SIZE, shuffle=True)
    test_loader = DataLoader(test_dataset, batch_size=BATCH_SIZE, shuffle=False)

    model = ShopIntentGRU(
        vocab_size=len(vocab),
        num_classes=len(unique_labels),
    ).to(DEVICE)

    label_counts = Counter(train_labels)
    class_weights = []

    for label in unique_labels:
        class_weights.append(len(train_labels) / (len(unique_labels) * label_counts[label]))

    class_weights = torch.tensor(class_weights, dtype=torch.float).to(DEVICE)

    criterion = nn.CrossEntropyLoss(weight=class_weights)
    optimizer = torch.optim.Adam(model.parameters(), lr=LEARNING_RATE)

    start_message = f"Training started at {datetime.now()} | Device: {DEVICE}"
    print(start_message)
    write_log(start_message)

    print("Train examples:", len(train_texts))
    print("Test examples:", len(test_texts))
    print("Vocab size:", len(vocab))
    print("Classes:", unique_labels)

    write_log(f"Train examples: {len(train_texts)}")
    write_log(f"Test examples: {len(test_texts)}")
    write_log(f"Vocab size: {len(vocab)}")
    write_log(f"Classes: {unique_labels}")

    best_accuracy = 0.0
    best_report = ""

    for epoch in range(EPOCHS):
        model.train()
        total_loss = 0.0

        for batch in train_loader:
            input_ids = batch["input_ids"].to(DEVICE)
            labels = batch["label"].to(DEVICE)

            optimizer.zero_grad()

            logits = model(input_ids)
            loss = criterion(logits, labels)

            loss.backward()
            optimizer.step()

            total_loss += loss.item()

        model.eval()
        all_preds = []
        all_true = []

        with torch.no_grad():
            for batch in test_loader:
                input_ids = batch["input_ids"].to(DEVICE)
                labels = batch["label"].to(DEVICE)

                logits = model(input_ids)
                preds = torch.argmax(logits, dim=1)

                all_preds.extend(preds.cpu().tolist())
                all_true.extend(labels.cpu().tolist())

        accuracy = accuracy_score(all_true, all_preds)

        log_line = f"Epoch {epoch + 1}/{EPOCHS} | Loss: {total_loss:.4f} | Accuracy: {accuracy:.4f}"
        print(log_line)
        write_log(log_line)

        if accuracy > best_accuracy:
            best_accuracy = accuracy
            torch.save(model.state_dict(), MODEL_PATH)

            best_report = classification_report(
                all_true,
                all_preds,
                labels=list(range(len(unique_labels))),
                target_names=unique_labels,
                zero_division=0,
            )

            write_log(f"Saved best model with accuracy: {best_accuracy:.4f}")

    with open(VOCAB_PATH, "w", encoding="utf-8") as file:
        json.dump(vocab, file, indent=2)

    with open(LABELS_PATH, "w", encoding="utf-8") as file:
        json.dump({
            "label_to_id": label_to_id,
            "id_to_label": id_to_label,
        }, file, indent=2)

    print("\nBest accuracy:", best_accuracy)
    print("\nBest classification report:")
    print(best_report)

    write_log("\nBest classification report:")
    write_log(best_report)
    write_log(f"Best accuracy: {best_accuracy:.4f}")

    print("\nSaved model:", MODEL_PATH)
    print("Saved vocab:", VOCAB_PATH)
    print("Saved labels:", LABELS_PATH)


if __name__ == "__main__":
    main()