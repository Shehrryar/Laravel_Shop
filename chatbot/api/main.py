from fastapi import FastAPI
from fastapi.middleware.cors import CORSMiddleware
from pydantic import BaseModel

from src.predict import IntentPredictor


app = FastAPI(title="Ecommerce Custom Chatbot API")

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

predictor = IntentPredictor()


class ChatRequest(BaseModel):
    message: str


@app.get("/")
def home():
    return {
        "status": True,
        "message": "Ecommerce chatbot model API is running"
    }


@app.post("/predict")
def predict(request: ChatRequest):
    result = predictor.predict(request.message)

    return {
        "status": True,
        "intent": result["intent"],
        "confidence": result["confidence"],
        "reply": result["reply"],
    }