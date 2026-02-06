const downloadInvoice = async () => {
    try {
        const response = await fetch(`/order/invoice-html/${order.id}`, {
            headers: { Accept: "application/json" },
        });
        const data = await response.json();
        // Create HTML content
        const htmlContent = `
            <html>
            <head>
                <title>Invoice #${data.id}</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; }
                    table { width: 100%; border-collapse: collapse; margin-top: 10px; }
                    th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
                    th { background-color: #f4f4f4; }
                </style>
            </head>
            <body>
                <h2>Invoice #${data.id}</h2>
                <p>Date: ${new Date(data.created_at).toLocaleDateString()}</p>
                <h4>Customer Info</h4>
                <p>${data.firstname} ${data.lastname}</p>
                <p>${data.address}, ${data.city}, ${data.state} ${data.zip}</p>
                <h4>Order Items</h4>
                <table>
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${data.order_items.map(item => `
                            <tr>
                                <td>${item.product?.title || item.name}</td>
                                <td>${item.quantity}</td>
                                <td>${item.price}</td>
                                <td>${item.total}</td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
                <h4>Total: ${data.grandtotal}</h4>
                <p>Payment Method: ${data.payment_method}</p>
                <p>Payment Status: ${data.payment_status}</p>
            </body>
            </html>
        `;
        // Create a Blob and trigger download
        const blob = new Blob([htmlContent], { type: "text/html" });
        const url = URL.createObjectURL(blob);
        const a = document.createElement("a");
        a.href = url;
        a.download = `Invoice_${data.id}.html`;
        a.click();
        URL.revokeObjectURL(url);
    } catch (error) {
        console.error("Failed to download invoice", error);
    }
};