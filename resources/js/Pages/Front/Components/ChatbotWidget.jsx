import React, { useRef, useState } from "react";

export default function ChatbotWidget() {
    const [isOpen, setIsOpen] = useState(false);
    const [message, setMessage] = useState("");
    const [loading, setLoading] = useState(false);
    const [messages, setMessages] = useState([
        {
            sender: "bot",
            text: "Hello! Welcome to our shop. How can I help you today?",
        },
    ]);

    const messagesEndRef = useRef(null);

    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        ?.getAttribute("content");

    const scrollToBottom = () => {
        setTimeout(() => {
            messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
        }, 100);
    };

    const addMessage = (sender, text) => {
        setMessages((previous) => [...previous, { sender, text }]);
        scrollToBottom();
    };

    const sendMessage = async () => {
        const userMessage = message.trim();

        if (!userMessage || loading) {
            return;
        }

        addMessage("user", userMessage);
        setMessage("");
        setLoading(true);

        try {
            const response = await fetch("/shopbot/ask", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: JSON.stringify({
                    message: userMessage,
                }),
            });

            const data = await response.json();

            if (!response.ok) {
                addMessage("bot", "Sorry, something went wrong. Please try again.");
                return;
            }

            addMessage("bot", data.reply || "Sorry, I could not understand.");
        } catch (error) {
            addMessage(
                "bot",
                "Chatbot service is not available. Please make sure the Python chatbot API is running."
            );
        } finally {
            setLoading(false);
        }
    };

    const handleKeyDown = (event) => {
        if (event.key === "Enter") {
            sendMessage();
        }
    };

    return (
        <>
            <button
                type="button"
                onClick={() => setIsOpen(true)}
                style={{
                    position: "fixed",
                    right: "22px",
                    bottom: "22px",
                    width: "58px",
                    height: "58px",
                    borderRadius: "50%",
                    border: "none",
                    background: "#111827",
                    color: "#ffffff",
                    fontSize: "25px",
                    cursor: "pointer",
                    zIndex: 99999,
                    boxShadow: "0 8px 24px rgba(0,0,0,0.28)",
                    display: isOpen ? "none" : "flex",
                    alignItems: "center",
                    justifyContent: "center",
                }}
            >
                💬
            </button>

            {isOpen && (
                <div
                    style={{
                        position: "fixed",
                        right: "22px",
                        bottom: "22px",
                        width: "360px",
                        maxWidth: "calc(100vw - 30px)",
                        height: "500px",
                        maxHeight: "calc(100vh - 40px)",
                        background: "#ffffff",
                        borderRadius: "16px",
                        boxShadow: "0 12px 35px rgba(0,0,0,0.28)",
                        zIndex: 99999,
                        display: "flex",
                        flexDirection: "column",
                        overflow: "hidden",
                        border: "1px solid #e5e7eb",
                    }}
                >
                    <div
                        style={{
                            background: "#111827",
                            color: "#ffffff",
                            padding: "14px 16px",
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "space-between",
                            fontWeight: "700",
                        }}
                    >
                        <span>Shop Assistant</span>
                        <button
                            type="button"
                            onClick={() => setIsOpen(false)}
                            style={{
                                background: "transparent",
                                border: "none",
                                color: "#ffffff",
                                fontSize: "22px",
                                cursor: "pointer",
                            }}
                        >
                            ×
                        </button>
                    </div>

                    <div
                        style={{
                            flex: 1,
                            padding: "14px",
                            overflowY: "auto",
                            background: "#f8fafc",
                        }}
                    >
                        {messages.map((item, index) => (
                            <div
                                key={index}
                                style={{
                                    display: "flex",
                                    justifyContent:
                                        item.sender === "user"
                                            ? "flex-end"
                                            : "flex-start",
                                    marginBottom: "10px",
                                }}
                            >
                                <div
                                    style={{
                                        maxWidth: "82%",
                                        padding: "10px 12px",
                                        borderRadius: "12px",
                                        whiteSpace: "pre-line",
                                        lineHeight: 1.45,
                                        fontSize: "14px",
                                        color: "#111827",
                                        background:
                                            item.sender === "user"
                                                ? "#dbeafe"
                                                : "#ffffff",
                                        border:
                                            item.sender === "user"
                                                ? "1px solid #bfdbfe"
                                                : "1px solid #e5e7eb",
                                    }}
                                >
                                    {item.text}
                                </div>
                            </div>
                        ))}

                        {loading && (
                            <div
                                style={{
                                    fontSize: "13px",
                                    color: "#6b7280",
                                    marginTop: "5px",
                                }}
                            >
                                Assistant is typing...
                            </div>
                        )}

                        <div ref={messagesEndRef} />
                    </div>

                    <div
                        style={{
                            display: "flex",
                            gap: "8px",
                            padding: "10px",
                            borderTop: "1px solid #e5e7eb",
                            background: "#ffffff",
                        }}
                    >
                        <input
                            type="text"
                            value={message}
                            onChange={(event) => setMessage(event.target.value)}
                            onKeyDown={handleKeyDown}
                            placeholder="Ask about products, orders, payment..."
                            style={{
                                flex: 1,
                                border: "1px solid #d1d5db",
                                borderRadius: "10px",
                                padding: "10px",
                                outline: "none",
                                fontSize: "14px",
                            }}
                        />

                        <button
                            type="button"
                            onClick={sendMessage}
                            disabled={loading}
                            style={{
                                border: "none",
                                borderRadius: "10px",
                                padding: "0 15px",
                                background: loading ? "#6b7280" : "#111827",
                                color: "#ffffff",
                                cursor: loading ? "not-allowed" : "pointer",
                                fontWeight: "600",
                            }}
                        >
                            Send
                        </button>
                    </div>
                </div>
            )}
        </>
    );
}