import './bootstrap';
import React, { useState, useEffect } from 'react';
import ReactDOM from 'react-dom/client';
import Notification from './component/notification';

const App = () => {
    const [notifications, setNotifications] = useState([]);
    useEffect(() => {
        window.Echo.channel('brts')
            .listen('.BrtCreated', (e) => {
                console.log(e);
                const { message, id } = e;
                let notf_id = id ?? Date.now();
                setNotifications(prevNotifications => [...prevNotifications, { id: notf_id, message, color: 'green' }]);
            });

        window.Echo.channel('brts')
            .listen('.BrtUpdated', (e) => {
                console.log(e);
                const { message, id } = e;
                let notf_id = id ?? Date.now();
                setNotifications(prevNotifications => [...prevNotifications, { id: notf_id, message, color: 'blue' }]);
            });

        window.Echo.channel('brts')
            .listen('.BrtDeleted', (e) => {
                console.log(e);
                const { message, id } = e;
                let notf_id = id ?? Date.now();
                setNotifications(prevNotifications => [...prevNotifications, { id: notf_id, message, color: 'red' }]);
            });
    }, []);

    return (<div>
        {
            notifications.map(notification => (
                <Notification key={notification.id} message={notification.message} color={notification.color} />))
        }
    </div>);
}

const app = document.getElementById('app');
if (app) {
    const root = ReactDOM.createRoot(app);

    root.render(<App />);
}