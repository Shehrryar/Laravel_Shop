import React, { useEffect, useRef, useState } from "react";

export default function CustomerAdminChatWidget() {
    const [isOpen, setIsOpen] = useState(false);
    const [message, setMessage] = useState("");
    const [messages, setMessages] = useState([]);
    const [customerId, setCustomerId] = useState(null);
    const [loading, setLoading] = useState(false);
    const [unreadCount, setUnreadCount] = useState(0);
    const [isLoggedIn, setIsLoggedIn] = useState(true);

    const messagesEndRef = useRef(null);
    const subscribedRef = useRef(false);

    const scrollToBottom = () => {
        setTimeout(() => {
            messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
        }, 100);
    };

    const fetchMessages = async () => {
        try {
            const response = await window.axios.get("/account/chat-box");

            setCustomerId(response.data.sender_id);
            setMessages(response.data.chat_message || []);
            setIsLoggedIn(true);

            if (isOpen) {
                setUnreadCount(0);
            }

            scrollToBottom();
        } catch (error) {
            setIsLoggedIn(false);
            setMessages([
                {
                    id: "login-message",
                    sender_id: 0,
                    receiver_id: 0,
                    message_content: "Please login first to chat with admin.",
                },
            ]);
        }
    };

    useEffect(() => {
        if (!customerId || subscribedRef.current || !window.Echo) {
            return;
        }

        subscribedRef.current = true;

        window.Echo.private(`chat.${customerId}`).listen(".message.sent", (data) => {
            const newMessage = data.message;

            setMessages((previous) => {
                const alreadyExists = previous.some(
                    (item) => String(item.id) === String(newMessage.id)
                );

                if (alreadyExists) {
                    return previous;
                }

                return [...previous, newMessage];
            });

            if (!isOpen) {
                setUnreadCount((previous) => previous + 1);
            }

            scrollToBottom();
        });

        return () => {
            window.Echo.leave(`private-chat.${customerId}`);
            subscribedRef.current = false;
        };
    }, [customerId, isOpen]);

    const openChat = async () => {
        setIsOpen(true);
        setUnreadCount(0);
        await fetchMessages();
    };

    const sendMessage = async () => {
        const text = message.trim();

        if (!text || loading || !isLoggedIn) {
            return;
        }

        setLoading(true);
        setMessage("");

        try {
            const response = await window.axios.post("/account/send-message", {
                message_content: text,
            });

            setMessages((previous) => [...previous, response.data]);
            scrollToBottom();
        } catch (error) {
            setMessages((previous) => [
                ...previous,
                {
                    id: Date.now(),
                    sender_id: 0,
                    receiver_id: 0,
                    message_content: "Message could not be sent. Please try again.",
                },
            ]);
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
                onClick={openChat}
                style={{
                    position: "fixed",
                    right: "22px",
                    bottom: "92px",
                    width: "58px",
                    height: "58px",
                    borderRadius: "50%",
                    border: "none",
                    background: "#2563eb",
                    color: "#ffffff",
                    fontSize: "23px",
                    cursor: "pointer",
                    zIndex: 99998,
                    boxShadow: "0 8px 24px rgba(0,0,0,0.25)",
                    display: isOpen ? "none" : "flex",
                    alignItems: "center",
                    justifyContent: "center",
                }}
                title="Chat with Admin"
            >
                👨‍💼

                {unreadCount > 0 && (
                    <span
                        style={{
                            position: "absolute",
                            top: "-5px",
                            right: "-5px",
                            background: "red",
                            color: "white",
                            borderRadius: "50%",
                            width: "22px",
                            height: "22px",
                            fontSize: "12px",
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "center",
                            fontWeight: "bold",
                        }}
                    >
                        {unreadCount}
                    </span>
                )}
            </button>

            {isOpen && (
                <div
                    style={{
                        position: "fixed",
                        right: "22px",
                        bottom: "92px",
                        width: "360px",
                        maxWidth: "calc(100vw - 30px)",
                        height: "500px",
                        maxHeight: "calc(100vh - 40px)",
                        background: "#ffffff",
                        borderRadius: "16px",
                        boxShadow: "0 12px 35px rgba(0,0,0,0.28)",
                        zIndex: 99998,
                        display: "flex",
                        flexDirection: "column",
                        overflow: "hidden",
                        border: "1px solid #e5e7eb",
                    }}
                >
                    <div
                        style={{
                            background: "#2563eb",
                            color: "#ffffff",
                            padding: "14px 16px",
                            display: "flex",
                            alignItems: "center",
                            justifyContent: "space-between",
                            fontWeight: "700",
                        }}
                    >
                        <span>Chat with Admin</span>

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
                        {messages.length === 0 && (
                            <div
                                style={{
                                    background: "#ffffff",
                                    border: "1px solid #e5e7eb",
                                    padding: "10px",
                                    borderRadius: "12px",
                                    fontSize: "14px",
                                }}
                            >
                                Start a conversation with admin.
                            </div>
                        )}

                        {messages.map((item, index) => {
                            const isMine =
                                customerId &&
                                String(item.sender_id) === String(customerId);

                            return (
                                <div
                                    key={item.id || index}
                                    style={{
                                        display: "flex",
                                        justifyContent: isMine ? "flex-end" : "flex-start",
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
                                            background: isMine ? "#dbeafe" : "#ffffff",
                                            border: isMine
                                                ? "1px solid #bfdbfe"
                                                : "1px solid #e5e7eb",
                                        }}
                                    >
                                        {item.message_content}

                                        {item.created_at && (
                                            <div
                                                style={{
                                                    marginTop: "5px",
                                                    fontSize: "10px",
                                                    color: "#6b7280",
                                                }}
                                            >
                                                {item.created_at}
                                            </div>
                                        )}
                                    </div>
                                </div>
                            );
                        })}

                        {loading && (
                            <div
                                style={{
                                    fontSize: "13px",
                                    color: "#6b7280",
                                }}
                            >
                                Sending...
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
                            disabled={!isLoggedIn}
                            onChange={(event) => setMessage(event.target.value)}
                            onKeyDown={handleKeyDown}
                            placeholder={
                                isLoggedIn
                                    ? "Type message to admin..."
                                    : "Please login first"
                            }
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
                            disabled={loading || !isLoggedIn}
                            style={{
                                border: "none",
                                borderRadius: "10px",
                                padding: "0 15px",
                                background: loading || !isLoggedIn ? "#6b7280" : "#2563eb",
                                color: "#ffffff",
                                cursor: loading || !isLoggedIn ? "not-allowed" : "pointer",
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