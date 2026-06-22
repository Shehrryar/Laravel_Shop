import json

import torch

from src.config import (
    CONFIDENCE_THRESHOLD,
    LABELS_PATH,
    MODEL_PATH,
    VOCAB_PATH,
)
from src.model import ShopIntentGRU, encode_text


DEVICE = "cuda" if torch.cuda.is_available() else "cpu"


SAFE_REPLIES = {
    "greeting": "Hello! Welcome to our shop. How can I help you today?",
    "product_search": "Sure, I can help you find products. Please tell me the product name or category.",
    "budget_products": "Sure, I can help you find budget-friendly products. Please tell me your price range.",
    "latest_products": "Sure, I can show you the latest products available in the shop.",
    "cart_checkout": "You can add a product to your cart and then continue to checkout.",
    "order_status": "Please login to your account to check your order status.",
    "order_cancel": "You can request order cancellation from your order page or contact support.",
    "return_refund": "You can request return, refund, or exchange according to the store policy.",
    "payment_methods": "You can pay using the available payment methods on the checkout page.",
    "shipping_info": "Delivery time and shipping charges depend on your location and product availability.",
    "account_help": "Please use the login or register page. If you forgot your password, use the password reset option.",
    "contact_support": "You can contact support using the admin chat option on the website.",
    "generic_shopping_advice": "I can help you with shopping advice. Please tell me what product you want to buy.",
    "general_support": "I can help you with products, orders, payment, shipping, returns, cart, account, and support.",
    "goodbye": "Thank you for visiting our shop. Have a nice day!",
    "unknown": "Sorry, I did not understand clearly. Please ask about products, orders, payment, shipping, returns, cart, account, or support.",
}


class IntentPredictor:
    def __init__(self):
        with open(VOCAB_PATH, "r", encoding="utf-8") as file:
            self.vocab = json.load(file)

        with open(LABELS_PATH, "r", encoding="utf-8") as file:
            labels_data = json.load(file)

        self.id_to_label = {
            int(key): value
            for key, value in labels_data["id_to_label"].items()
        }

        self.model = ShopIntentGRU(
            vocab_size=len(self.vocab),
            num_classes=len(self.id_to_label),
        ).to(DEVICE)

        self.model.load_state_dict(torch.load(MODEL_PATH, map_location=DEVICE))
        self.model.eval()

    def predict(self, message):
        input_ids = encode_text(message, self.vocab)
        input_tensor = torch.tensor([input_ids], dtype=torch.long).to(DEVICE)

        with torch.no_grad():
            logits = self.model(input_tensor)
            probabilities = torch.softmax(logits, dim=1)[0]

        confidence, pred_id = torch.max(probabilities, dim=0)

        confidence = float(confidence.item())
        intent = self.id_to_label[int(pred_id.item())]

        if confidence < CONFIDENCE_THRESHOLD:
            intent = "unknown"

        reply = SAFE_REPLIES.get(intent, SAFE_REPLIES["unknown"])

        return {
            "intent": intent,
            "confidence": confidence,
            "reply": reply,
        }


def main():
    predictor = IntentPredictor()

    print("Model loaded successfully.")
    print("Device:", DEVICE)
    print("Type exit to stop.")

    while True:
        message = input("\nYou: ")

        if message.lower().strip() in ["exit", "quit"]:
            break

        result = predictor.predict(message)

        print("Intent:", result["intent"])
        print("Confidence:", round(result["confidence"], 4))
        print("Reply:", result["reply"])


if __name__ == "__main__":
    main()