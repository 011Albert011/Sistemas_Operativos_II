// Datos de productos (autos)
const products = [
    {
        id: 1,
        name: "Toyota RAV4 2022",
        category: "suv",
        price: 27999,
        image: "https://toyotaoaxaca.com.mx/wp-content/uploads/2019/01/diseno-trasero-rav4-350x240.jpg",
        description: "SUV confiable, eficiente y espaciosa"
    },
    {
        id: 2,
        name: "Honda Civic 2021",
        category: "sedan",
        price: 21999,
        image: "https://images.unsplash.com/photo-1709100374265-9eb9da6a9192?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        description: "Sedán cómodo y económico"
    },
    {
        id: 3,
        name: "Tesla Model 3",
        category: "electrico",
        price: 39999,
        image: "https://images.unsplash.com/photo-1677792538242-3b5b0855ff51?q=80&w=764&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D",
        description: "100% eléctrico, autonomía extendida"
    },
    {
        id: 4,
        name: "Ford Mustang GT",
        category: "deportivo",
        price: 55999,
        image: "https://images.unsplash.com/photo-1493238792000-8113da705763?auto=format&fit=crop&w=800&q=80",
        description: "Deportivo potente y elegante"
    },
    {
        id: 5,
        name: "Nissan Kicks",
        category: "suv",
        price: 18999,
        image: "https://www.nissan.com.mx/content/dam/Nissan/mexico/assets/kicks_play_e_power/my25/vlp/diseno/nissan-2025-kicks_play_e_power_platinum-blanco_bitono-negro-exterior-diseno-aleron.jpg.ximg.l_12_h.smart.jpg",
        description: "Compacto, ideal para ciudad"
    },
    {
        id: 6,
        name: "BMW Serie 3",
        category: "sedan",
        price: 34999,
        image: "https://images.unsplash.com/photo-1511919884226-fd3cad34687c?auto=format&fit=crop&w=800&q=80",
        description: "Lujo, performance y tecnología"
    }
];

let cart = [];
let currentFilter = "todos";

// Renderizar productos
function renderProducts() {
    const productsGrid = document.getElementById("productsGrid");
    productsGrid.innerHTML = "";

    const filteredProducts = currentFilter === "todos" 
        ? products 
        : products.filter(p => p.category === currentFilter);

    filteredProducts.forEach(product => {
        const productCard = document.createElement("div");
        productCard.className = "product-card";
        productCard.innerHTML = `
            <div class="product-image"><img src="${product.image}" alt="${product.name}"></div>
            <div class="product-info">
                <div class="product-category">${product.category.toUpperCase()}</div>
                <div class="product-name">${product.name}</div>
                <div class="product-price">$${product.price.toFixed(2)}</div>
                <div class="product-description">${product.description}</div>
                <button class="add-to-cart-btn" onclick="addToCart(${product.id})">
                    Agregar al Carrito
                </button>
            </div>
        `;
        productsGrid.appendChild(productCard);
    });
}

// Filtrar productos
function filterProducts(category, btnEl) {
    currentFilter = category;

    // Actualizar botones activos
    document.querySelectorAll(".filter-btn").forEach(btn => {
        btn.classList.remove("active");
    });
    if (btnEl) btnEl.classList.add("active");

    renderProducts();
}

// Filtrar productos
function filterProducts(category) {
    currentFilter = category;

    // Actualizar botones activos
    document.querySelectorAll(".filter-btn").forEach(btn => {
        btn.classList.remove("active");
    });
    event.target.classList.add("active");

    renderProducts();
}

// Agregar al carrito
function addToCart(productId) {
    const product = products.find(p => p.id === productId);
    const existingItem = cart.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
    } else {
        cart.push({
            ...product,
            quantity: 1
        });
    }

    updateCart();
    showNotification(`${product.name} agregado al carrito`);
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
    renderProducts();
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
