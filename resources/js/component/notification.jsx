import React, { useState, useEffect } from "react";
import '../../css/notification.css';

const Notification = ({ message, color }) => {
    const [visible, setVisible] = useState(true);
    useEffect(() => {
        const timer = setTimeout(() => { setVisible(false); }, 5000);
        return () => clearTimeout(timer);
    }, []);
    if (!visible) return null;
    return (<div className="notification" style={{ backgroundColor: color }}> {message} </div>);
}

export default Notification;

