import React, { useEffect, useRef, useState } from "react";
import axios from "axios";

const quickQuestions = [
    "Track my order",
    "Return policy",
    "Budget products",
    "Installment option",
];

const ChatbotWidget = () => {
    const [open, setOpen] = useState(false);
    const [input, setInput] = useState("");
    const [sending, setSending] = useState(false);
    const [messages, setMessages] = useState([
        {
            id: 1,
            from: "bot",
            text: "Hello! I am your shop assistant. Ask me about orders, returns, budget products, gaming products, installments, or product search.",
        },
    ]);

    const bodyRef = useRef(null);

    useEffect(() => {
        if (bodyRef.current) {
            bodyRef.current.scrollTop = bodyRef.current.scrollHeight;
        }
    }, [messages, open]);

    const csrf = () => {
        return document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "";
    };

    const sendMessage = async (text = input) => {
        const cleanText = text.trim();

        if (!cleanText || sending) {
            return;
        }

        setInput("");
        setSending(true);

        setMessages((prev) => [
            ...prev,
            {
                id: Date.now(),
                from: "user",
                text: cleanText,
            },
        ]);

        try {
            const res = await axios.post(
                "/chatbot/message",
                {
                    message: cleanText,
                },
                {
                    headers: {
                        "X-CSRF-TOKEN": csrf(),
                    },
                }
            );

            setMessages((prev) => [
                ...prev,
                {
                    id: Date.now() + 1,
                    from: "bot",
                    text: res.data?.reply || "I received your message.",
                },
            ]);
        } catch (error) {
            setMessages((prev) => [
                ...prev,
                {
                    id: Date.now() + 2,
                    from: "bot",
                    text: "Sorry, the chatbot is not available right now. Please try again later.",
                },
            ]);
        } finally {
            setSending(false);
        }
    };

    if (!open) {
        return (
            <button
                type="button"
                onClick={() => setOpen(true)}
                style={{
                    position: "fixed",
                    right: "18px",
                    bottom: "86px",
                    width: "56px",
                    height: "56px",
                    borderRadius: "50%",
                    border: "none",
                    background: "#ff4c3b",
                    color: "#fff",
                    boxShadow: "0 10px 25px rgba(0,0,0,0.22)",
                    zIndex: 9999,
                    fontSize: "24px",
                    cursor: "pointer",
                }}
            >
                💬
            </button>
        );
    }

    return (
        <div
            style={{
                position: "fixed",
                right: "14px",
                bottom: "82px",
                width: "360px",
                maxWidth: "calc(100vw - 28px)",
                height: "500px",
                maxHeight: "calc(100vh - 115px)",
                background: "#fff",
                borderRadius: "22px",
                boxShadow: "0 16px 45px rgba(0,0,0,0.25)",
                zIndex: 10000,
                overflow: "hidden",
                display: "flex",
                flexDirection: "column",
                border: "1px solid rgba(0,0,0,0.06)",
            }}
        >
            <div
                style={{
                    background: "linear-gradient(135deg, #ff4c3b, #ff7a59)",
                    color: "#fff",
                    padding: "14px 16px",
                    display: "flex",
                    alignItems: "center",
                    justifyContent: "space-between",
                }}
            >
                <div>
                    <h3 style={{ margin: 0, fontSize: "16px", fontWeight: 800 }}>
                        Shop Chatbot
                    </h3>
                    <p style={{ margin: "3px 0 0", fontSize: "12px" }}>
                        Fast help for search, orders, returns, and payments
                    </p>
                </div>

                <button
                    type="button"
                    onClick={() => setOpen(false)}
                    style={{
                        border: "none",
                        background: "rgba(255,255,255,0.2)",
                        color: "#fff",
                        width: "32px",
                        height: "32px",
                        borderRadius: "50%",
                        cursor: "pointer",
                        fontSize: "18px",
                    }}
                >
                    ×
                </button>
            </div>

            <div
                style={{
                    display: "flex",
                    gap: "7px",
                    flexWrap: "wrap",
                    padding: "10px 12px",
                    background: "#fff",
                }}
            >
                {quickQuestions.map((question) => (
                    <button
                        key={question}
                        type="button"
                        onClick={() => sendMessage(question)}
                        style={{
                            border: "1px solid #ffd2cb",
                            color: "#ff4c3b",
                            background: "#fff6f4",
                            borderRadius: "999px",
                            padding: "6px 10px",
                            fontSize: "12px",
                            cursor: "pointer",
                        }}
                    >
                        {question}
                    </button>
                ))}
            </div>

            <div
                ref={bodyRef}
                style={{
                    flex: 1,
                    padding: "14px",
                    overflowY: "auto",
                    background: "#f7f7f8",
                }}
            >
                {messages.map((message) => {
                    const fromUser = message.from === "user";

                    return (
                        <div
                            key={message.id}
                            style={{
                                display: "flex",
                                justifyContent: fromUser ? "flex-end" : "flex-start",
                                marginBottom: "10px",
                            }}
                        >
                            <div
                                style={{
                                    maxWidth: "82%",
                                    padding: "10px 12px",
                                    borderRadius: fromUser
                                        ? "16px 16px 4px 16px"
                                        : "16px 16px 16px 4px",
                                    background: fromUser ? "#ff4c3b" : "#fff",
                                    color: fromUser ? "#fff" : "#222",
                                    boxShadow: "0 4px 12px rgba(0,0,0,0.08)",
                                    fontSize: "13px",
                                    lineHeight: 1.45,
                                    whiteSpace: "pre-wrap",
                                }}
                            >
                                {message.text}
                            </div>
                        </div>
                    );
                })}

                {sending && (
                    <div style={{ marginBottom: "10px" }}>
                        <div
                            style={{
                                display: "inline-block",
                                background: "#fff",
                                padding: "10px 12px",
                                borderRadius: "16px",
                                fontSize: "13px",
                            }}
                        >
                            Typing...
                        </div>
                    </div>
                )}
            </div>

            <form
                onSubmit={(event) => {
                    event.preventDefault();
                    sendMessage();
                }}
                style={{
                    display: "flex",
                    gap: "8px",
                    padding: "12px",
                    background: "#fff",
                    borderTop: "1px solid #eee",
                }}
            >
                <input
                    value={input}
                    placeholder="Type your message..."
                    onChange={(event) => setInput(event.target.value)}
                    style={{
                        flex: 1,
                        border: "1px solid #e5e5e5",
                        borderRadius: "999px",
                        padding: "10px 13px",
                        outline: "none",
                        fontSize: "13px",
                    }}
                />

                <button
                    type="submit"
                    disabled={sending}
                    style={{
                        border: "none",
                        background: "#ff4c3b",
                        color: "#fff",
                        borderRadius: "999px",
                        padding: "0 14px",
                        fontWeight: 700,
                        cursor: "pointer",
                    }}
                >
                    Send
                </button>
            </form>
        </div>
    );
};

export default ChatbotWidget;