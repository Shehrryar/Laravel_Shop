from pathlib import Path

BASE_DIR = Path(__file__).resolve().parents[1]

DATA_DIR = BASE_DIR / "data"
RAW_DIR = DATA_DIR / "raw"
PROCESSED_DIR = DATA_DIR / "processed"
CUSTOM_EXAMPLES_DIR = DATA_DIR / "custom_examples"

OUTPUT_DIR = BASE_DIR / "outputs"
MODEL_DIR = OUTPUT_DIR / "models"
REPORT_DIR = OUTPUT_DIR / "reports"

# Bitext Gen AI Chatbot Customer Support Dataset
HF_DATASET_NAME = "bitext/Bitext-customer-support-llm-chatbot-training-dataset"

CUSTOM_EXAMPLES_FILE = CUSTOM_EXAMPLES_DIR / "laravel_shop_examples.csv"

TRAIN_CSV = PROCESSED_DIR / "train.csv"
TEST_CSV = PROCESSED_DIR / "test.csv"
RESPONSES_JSON = PROCESSED_DIR / "responses_by_intent.json"

MODEL_PATH = MODEL_DIR / "shop_intent_gru.pt"
VOCAB_PATH = MODEL_DIR / "vocab.json"
LABELS_PATH = MODEL_DIR / "labels.json"

CLASSIFICATION_REPORT_PATH = REPORT_DIR / "classification_report.txt"
TRAINING_LOG_PATH = REPORT_DIR / "training_log.txt"
MAX_LEN = 40
BATCH_SIZE = 64
EMBED_DIM = 128
HIDDEN_DIM = 128
EPOCHS = 12
LEARNING_RATE = 1e-3
CONFIDENCE_THRESHOLD = 0.45