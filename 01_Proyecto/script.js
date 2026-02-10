// Carrito (el contenido de productos viene desde PHP)

let cart = [];

// Agregar al carrito
function addToCart(productId, productName, productPrice) {
    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            id: productId,
            name: productName,
            price: productPrice,
            quantity: 1
        });
    }

    updateCart();
    showNotification(`${productName} agregado al carrito`);
}

// Actualizar carrito
function updateCart() {
    const cartItemsDiv = document.getElementById("cartItems");
    const cartCount = document.getElementById("cartCount");
    const cartTotal = document.getElementById("cartTotal");

    if (cart.length === 0) {
        cartItemsDiv.innerHTML = '<p class="empty-cart">El carrito está vacío</p>';
        cartCount.textContent = "0";
        cartTotal.textContent = "0.00";
        return;
    }

    cartItemsDiv.innerHTML = "";
    let total = 0;
    let count = 0;

    cart.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        count += item.quantity;

        const cartItem = document.createElement("div");
        cartItem.className = "cart-item";
        cartItem.innerHTML = `
            <div class="cart-item-info">
                <div class="cart-item-name">${item.name}</div>
                <div>Cantidad: ${item.quantity}</div>
                <div class="cart-item-price">$${itemTotal.toFixed(2)}</div>
            </div>
            <button class="cart-item-remove" onclick="removeFromCart(${item.id})">🗑️</button>
        `;
        cartItemsDiv.appendChild(cartItem);
    });

    cartCount.textContent = count;
    cartTotal.textContent = total.toFixed(2);
}

// Eliminar del carrito
function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCart();
}

// Toggle carrito
function toggleCart() {
    document.getElementById("cartSidebar").classList.toggle("active");
}

// Checkout
function checkout() {
    if (cart.length === 0) {
        alert("El carrito está vacío");
        return;
    }

    const total = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
    alert(`¡Compra completada! Total: $${total.toFixed(2)}\n\nGracias por tu compra en StyleHub.`);
    
    cart = [];
    updateCart();
    toggleCart();
}

// Notificación
function showNotification(message) {
    const notification = document.createElement("div");
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background: linear-gradient(135deg, #ff6b6b, #4ecdc4);
        color: white;
        padding: 1rem 2rem;
        border-radius: 8px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        z-index: 999;
        animation: slideIn 0.3s ease;
    `;
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.style.animation = "slideOut 0.3s ease";
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Animaciones CSS
const style = document.createElement("style");
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }

    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

// Scroll suave
function scrollToProducts() {
    document.getElementById("productos").scrollIntoView({ behavior: "smooth" });
}

// Manejo de formulario de contacto
function handleSubmit(event) {
    event.preventDefault();
    showNotification("¡Mensaje enviado! Nos pondremos en contacto pronto.");
    event.target.reset();
}

// Inicializar
document.addEventListener("DOMContentLoaded", () => {
    updateCart();
});

// Cerrar carrito al hacer clic fuera
document.addEventListener("click", (e) => {
    const cartSidebar = document.getElementById("cartSidebar");
    const cartIcon = document.querySelector(".cart-icon");
    
    if (!cartSidebar.contains(e.target) && !cartIcon.contains(e.target)) {
        cartSidebar.classList.remove("active");
    }
});