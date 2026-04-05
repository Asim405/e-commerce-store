// Add to Cart
function addToCart(productId) {
    fetch('ajax/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=add&product_id=' + productId
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('Product added to cart!');
            updateCartBadge(data.cart_count);
        }
    })
    .catch(err => console.error(err));
}

// Update Quantity
function updateQty(cartId, change) {
    fetch('ajax/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=update&cart_id=' + cartId + '&change=' + change
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            if (data.quantity <= 0) {
                document.getElementById('cart-item-' + cartId).remove();
            } else {
                document.getElementById('qty-' + cartId).textContent = data.quantity;
            }
            location.reload();
        }
    });
}

// Remove Item
function removeItem(cartId) {
    if (!confirm('Remove this item from cart?')) return;
    fetch('ajax/cart.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'action=remove&cart_id=' + cartId
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            document.getElementById('cart-item-' + cartId).remove();
            updateCartBadge(data.cart_count);
            showToast('Item removed!');
            location.reload();
        }
    });
}

// Update Cart Badge
function updateCartBadge(count) {
    let badge = document.querySelector('.cart-badge');
    if (count > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'cart-badge';
            document.querySelector('.cart-icon').appendChild(badge);
        }
        badge.textContent = count;
    } else {
        if (badge) badge.remove();
    }
}

// Toast Notification
function showToast(message) {
    const toast = document.createElement('div');
    toast.textContent = message;
    toast.style.cssText = `
        position: fixed;
        bottom: 30px;
        right: 30px;
        background: #222;
        color: #fff;
        padding: 14px 24px;
        border-radius: 8px;
        font-size: 0.9rem;
        z-index: 9999;
        animation: fadeIn 0.3s ease;
    `;
    document.body.appendChild(toast);
    setTimeout(() => toast.remove(), 3000);
}