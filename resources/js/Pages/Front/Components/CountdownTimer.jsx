import React ,{ useEffect, useState, memo } from "react";


function CountdownTimer({ initialSeconds = 3600 }) {
    const [timeLeft, setTimeLeft] = useState(initialSeconds);

    useEffect(() => {
        if (timeLeft <= 0) return;

        const interval = setInterval(() => {
            setTimeLeft(prev => prev - 1);
        }, 1000);

        return () => clearInterval(interval);
    }, [timeLeft]);

    const hours = String(Math.floor(timeLeft / 3600)).padStart(2, "0");
    const minutes = String(Math.floor((timeLeft % 3600) / 60)).padStart(2, "0");
    const seconds = String(timeLeft % 60).padStart(2, "0");

    return (
        <div className="counters">
            <div className="counter">
                <span>{hours}</span>
                <p>Hours</p>
            </div>
            <div className="counter">
                <span>{minutes}</span>
                <p>Minutes</p>
            </div>
            <div className="counter">
                <span>{seconds}</span>
                <p>Seconds</p>
            </div>
        </div>
    );
}

export default memo(CountdownTimer);
