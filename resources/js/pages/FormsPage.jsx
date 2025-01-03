// resources/js/Pages/FormsPage.jsx
import React, { useState } from 'react';
import axios from 'axios';
import swal from 'sweetalert';
import Cookies from 'js-cookie';

export default function FormsPage() {
    const [balance, setBalance] = useState('');
    const [amount, setAmount] = useState('');
    const [to, setEmail] = useState('');
    const [item, setItemName] = useState('');
    const [price, setItemPrice] = useState('');

    const handleShowBalance = async () => {
        // Simulate fetching balance
        const token = Cookies.get('mgac_tk');
        try {
            var response = await axios.get('/api/wallet/balance', { headers: { 'Authorization': `Bearer ${token}` } });
            const { data } = response;
            setBalance(data.balance);
        } catch (err) {
            console.log(err);
            var message = (err.response.data.message || err.response.data.error) ?? '';
            swal("Wallet", `Wallet Error: ${message}`, 'error');
        }
    };

    const handleTransfer = async (event) => {
        event.preventDefault();
        // Handle transfer logic here
        // console.log('Amount:', amount);
        // console.log('Email:', to);
        const token = Cookies.get('mgac_tk');
        try {
            var response = await axios.post('/api/wallet/transfer', { to, amount },
                { headers: { 'Authorization': `Bearer ${token}` } });

            const { message } = response.data;
            swal("Transfer", (message || 'Transfer Successful'), 'success');
        }
        catch (err) {
            console.log(err);
            var message = (err.response.data.message || err.response.data.error) ?? '';
            swal("Transfer", `Transfer Error: ${message}`, 'error');
        }
    };

    const handleInitiateOrder = async (event) => {
        event.preventDefault();
        // Handle order initiation logic here
        console.log('Item Name:', item);
        console.log('Item Price:', price);

        const token = Cookies.get('mgac_tk');
        try {
            var response = await axios.post('/api/order/initiate', { item, price },
                { headers: { 'Authorization': `Bearer ${token}` } });

            const { message } = response.data;
            swal("Initiate Order", (message || 'Transfer Successful'), 'success');
        }
        catch (err) {
            console.log(err);
            var message = (err.response.data.message || err.response.data.error) ?? '';
            swal("Initiate Order", `Order Error: ${message}`, 'error');
        }
    };

    return (
        <div className="forms-page">
            <a href="/api/documentation">Documentation</a>

            <div className="form-section">
                <h2>Wallet Balance</h2>
                <div className="balance-container">
                    <button onClick={handleShowBalance}>Show Balance</button>
                    <input type="text" value={balance} readOnly />
                </div>
            </div>

            <div className="form-section">
                <h2>Transfer</h2>
                <form onSubmit={handleTransfer}>
                    <div className="form-group">
                        <label htmlFor="amount">Amount:</label>
                        <input
                            type="number"
                            id="amount"
                            value={amount}
                            onChange={(e) => setAmount(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="to">Email:</label>
                        <input
                            type="email"
                            id="to"
                            value={to}
                            onChange={(e) => setEmail(e.target.value)}
                            required
                        />
                    </div>
                    <button type="submit">Transfer</button>
                </form>
            </div>

            <div className="form-section">
                <h2>Initiate Order</h2>
                <form onSubmit={handleInitiateOrder}>
                    <div className="form-group">
                        <label htmlFor="item">Item Name:</label>
                        <input
                            type="text"
                            id="item"
                            value={item}
                            onChange={(e) => setItemName(e.target.value)}
                            required
                        />
                    </div>
                    <div className="form-group">
                        <label htmlFor="price">Item Price:</label>
                        <input
                            type="number"
                            id="price"
                            value={price}
                            onChange={(e) => setItemPrice(e.target.value)}
                            required
                        />
                    </div>
                    <button type="submit">Initiate Order</button>
                </form>
            </div>
        </div>
    );
}
