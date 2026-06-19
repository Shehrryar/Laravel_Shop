import re

import torch
import torch.nn as nn

from src.config import EMBED_DIM, HIDDEN_DIM, MAX_LEN


def tokenize(text: str):
    text = str(text).lower()
    text = re.sub(r"[^a-z0-9\s]", " ", text)
    text = re.sub(r"\s+", " ", text).strip()
    return text.split()


def build_vocab(texts, min_freq=1):
    freq = {}

    for text in texts:
        for token in tokenize(text):
            freq[token] = freq.get(token, 0) + 1

    vocab = {
        "<PAD>": 0,
        "<UNK>": 1,
    }

    for word, count in sorted(freq.items()):
        if count >= min_freq:
            vocab[word] = len(vocab)

    return vocab


def encode_text(text, vocab):
    tokens = tokenize(text)
    ids = [vocab.get(token, vocab["<UNK>"]) for token in tokens]

    if len(ids) > MAX_LEN:
        ids = ids[:MAX_LEN]

    while len(ids) < MAX_LEN:
        ids.append(vocab["<PAD>"])

    return ids


class ShopIntentGRU(nn.Module):
    def __init__(self, vocab_size, num_classes):
        super().__init__()

        self.embedding = nn.Embedding(
            num_embeddings=vocab_size,
            embedding_dim=EMBED_DIM,
            padding_idx=0,
        )

        self.gru = nn.GRU(
            input_size=EMBED_DIM,
            hidden_size=HIDDEN_DIM,
            batch_first=True,
            bidirectional=True,
        )

        self.dropout = nn.Dropout(0.35)
        self.classifier = nn.Linear(HIDDEN_DIM * 2, num_classes)

    def forward(self, input_ids):
        x = self.embedding(input_ids)
        _, hidden = self.gru(x)

        forward_hidden = hidden[-2]
        backward_hidden = hidden[-1]

        pooled = torch.cat([forward_hidden, backward_hidden], dim=1)
        pooled = self.dropout(pooled)

        return self.classifier(pooled)