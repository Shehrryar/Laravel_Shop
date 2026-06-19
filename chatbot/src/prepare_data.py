import json
import re

import pandas as pd
from datasets import load_dataset
from sklearn.model_selection import train_test_split

from src.config import (
    CUSTOM_EXAMPLES_FILE,
    HF_DATASET_NAME,
    PROCESSED_DIR,
    RESPONSES_JSON,
    TEST_CSV,
    TRAIN_CSV,
)


def clean_text(text):
    text = str(text).lower()
    text = re.sub(r"\{\{.*?\}\}", " ", text)
    text = re.sub(r"[^a-z0-9\s]", " ", text)
    text = re.sub(r"\s+", " ", text).strip()
    return text


def map_to_shop_intent(original_intent, category, instruction):
    original_intent = str(original_intent).lower()
    category = str(category).lower()
    instruction = str(instruction).lower()

    combined = f"{original_intent} {category} {instruction}"

    if any(w in combined for w in ["hello", "hi ", "hey", "greeting"]):
        return "greeting"

    if any(w in combined for w in ["cancel_order", "cancel order", "cancel purchase"]):
        return "order_cancel"

    if any(w in combined for w in ["track_order", "track order", "order status", "where is my order"]):
        return "order_status"

    if any(w in combined for w in ["place_order", "change_order", "order", "purchase"]):
        return "order_status"

    if any(w in combined for w in ["refund", "return", "exchange", "damaged", "wrong item", "broken"]):
        return "return_refund"

    if any(w in combined for w in ["payment", "pay", "card", "cash", "paypal", "stripe", "invoice", "check_invoice"]):
        return "payment_methods"

    if any(w in combined for w in ["shipping", "delivery", "shipment", "deliver"]):
        return "shipping_info"

    if any(w in combined for w in ["account", "login", "password", "register", "sign up", "profile"]):
        return "account_help"

    if any(w in combined for w in ["cart", "checkout", "add product", "remove product"]):
        return "cart_checkout"

    if any(w in combined for w in ["support", "agent", "human", "customer service", "contact"]):
        return "contact_support"

    if any(w in combined for w in ["product", "availability", "item", "stock"]):
        return "product_search"

    if any(w in combined for w in ["discount", "offer", "sale", "cheap", "budget"]):
        return "budget_products"

    return "general_support"


def add_response(responses_by_intent, intent, response):
    response = str(response).strip()

    if not response:
        return

    responses_by_intent.setdefault(intent, [])

    if response not in responses_by_intent[intent] and len(responses_by_intent[intent]) < 30:
        responses_by_intent[intent].append(response)


def add_default_responses(responses_by_intent):
    defaults = {
        "greeting": "Hello! Welcome to our shop. How can I help you today?",
        "product_search": "Sure, I can help you find products.",
        "budget_products": "Sure, I can show you budget-friendly products.",
        "latest_products": "Here are the latest products available in the shop.",
        "order_status": "Please login to your account to check your order status.",
        "order_cancel": "You can request order cancellation from your order page or contact support.",
        "return_refund": "You can request return, refund, or exchange according to the store policy.",
        "payment_methods": "You can pay using the available payment methods on the checkout page.",
        "shipping_info": "Delivery time and shipping charges depend on your location and product availability.",
        "cart_checkout": "Open the product page, click Add to Cart, then go to Cart and Checkout.",
        "account_help": "Please use the login or register page. If you forgot your password, use the password reset option.",
        "contact_support": "You can contact support using the admin chat option on the website.",
        "generic_shopping_advice": "I can help you with shopping advice. Please tell me what product you want to buy.",
        "general_support": "I can help you with product, order, payment, shipping, return, account, and support questions.",
        "goodbye": "Thank you for visiting our shop. Have a nice day!",
        "unknown": "Sorry, I did not understand clearly. Please ask about products, orders, payment, shipping, returns, cart, account, or support.",
    }

    for intent, response in defaults.items():
        responses_by_intent.setdefault(intent, [])

        if response not in responses_by_intent[intent]:
            responses_by_intent[intent].insert(0, response)


def main():
    PROCESSED_DIR.mkdir(parents=True, exist_ok=True)

    rows = []
    responses_by_intent = {}

    print("Downloading Bitext Gen AI Chatbot Customer Support Dataset...")
    dataset = load_dataset(HF_DATASET_NAME, split="train")
    df = pd.DataFrame(dataset)

    print("Dataset columns:", df.columns.tolist())
    print("Total raw rows:", len(df))

    for _, row in df.iterrows():
        instruction = row.get("instruction", "")
        original_intent = row.get("intent", "")
        category = row.get("category", "")
        response = row.get("response", "")

        instruction_clean = clean_text(instruction)

        if not instruction_clean:
            continue

        mapped_intent = map_to_shop_intent(
            original_intent,
            category,
            instruction,
        )

        rows.append({
            "text": instruction_clean,
            "intent": mapped_intent,
        })

        add_response(responses_by_intent, mapped_intent, response)

    if CUSTOM_EXAMPLES_FILE.exists():
        print("Adding Laravel shop custom examples:", CUSTOM_EXAMPLES_FILE)

        custom_df = pd.read_csv(CUSTOM_EXAMPLES_FILE)

        for _, row in custom_df.iterrows():
            text = clean_text(row.get("text", ""))
            intent = str(row.get("intent", "")).strip()

            if text and intent:
                rows.append({
                    "text": text,
                    "intent": intent,
                })

    add_default_responses(responses_by_intent)

    final_df = pd.DataFrame(rows)
    final_df = final_df.drop_duplicates()
    final_df = final_df.dropna()
    final_df = final_df[final_df["text"].str.len() > 2]

    counts = final_df["intent"].value_counts()
    valid_intents = counts[counts >= 2].index.tolist()
    final_df = final_df[final_df["intent"].isin(valid_intents)]

    print("\nFinal intent counts:")
    print(final_df["intent"].value_counts())

    train_df, test_df = train_test_split(
        final_df,
        test_size=0.2,
        random_state=42,
        stratify=final_df["intent"],
    )

    train_df.to_csv(TRAIN_CSV, index=False)
    test_df.to_csv(TEST_CSV, index=False)

    with open(RESPONSES_JSON, "w", encoding="utf-8") as file:
        json.dump(responses_by_intent, file, indent=2, ensure_ascii=False)

    print("\nSaved:", TRAIN_CSV)
    print("Saved:", TEST_CSV)
    print("Saved:", RESPONSES_JSON)
    print("Total final examples:", len(final_df))


if __name__ == "__main__":
    main()