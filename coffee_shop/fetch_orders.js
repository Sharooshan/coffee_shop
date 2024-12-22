document.addEventListener('DOMContentLoaded', function() {
    fetch('view_orders.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log('Data received:', data); // Check data received in console

            const ordersTableBody = document.getElementById('orders-table-body');

            if (data.length > 0) {
                data.forEach(order => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${order.id}</td>
                        <td>${order.user_id}</td>
                        <td>${order.user_email}</td>
                        <td>${order.coffee_name}</td>
                        <td>${order.quantity}</td>
                        <td>${order.customer_name}</td>
                        <td>${order.contact_number}</td>
                        <td>${order.order_date}</td>
                    `;
                  //  ordersTableBody.appendChild(row);
                });
            } else {
                ordersTableBody.innerHTML = '<tr><td colspan="8">No orders found</td></tr>';
            }
        })
        .catch(error => {
            console.error('Error fetching orders:', error);
        });
});
