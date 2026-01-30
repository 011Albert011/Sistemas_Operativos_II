// Datos de productos
const products = [
    {
        id: 1,
        name: "Camiseta Básica Blanca",
        category: "hombres",
        price: 19.99,
        image: "👕",
        description: "Cómoda y versátil para cualquier ocasión"
    },
    {
        id: 2,
        name: "Jeans Azul Oscuro",
        category: "hombres",
        price: 59.99,
        image: "👖",
        description: "Estilo clásico y duradero"
    },
    {
        id: 3,
        name: "Chaqueta Deportiva",
        category: "hombres",
        price: 89.99,
        image: "🧥",
        description: "Perfecta para entrenamientos"
    },
    {
        id: 4,
        name: "Vestido Negro",
        category: "mujeres",
        price: 79.99,
        image: "👗",
        description: "Elegante y sofisticado"
    },
    {
        id: 5,
        name: "Falda Plisada",
        category: "mujeres",
        price: 49.99,
        image: "👚",
        description: "Estilo moderno y cómodo"
    },
    {
        id: 6,
        name: "Blusa Floral",
        category: "mujeres",
        price: 39.99,
        image: "👔",
        description: "Fresca y colorida"
    },
    {
        id: 7,
        name: "Zapatos Deportivos",
        category: "accesorios",
        price: 99.99,
        image: "👟",
        description: "Cómodos y de moda"
    },
    {
        id: 8,
        name: "Bolso Casual",
        category: "accesorios",
        price: 69.99,
        image: "👜",
        description: "Perfecto para el día a día"
    },
    {
        id: 9,
        name: "Gafas de Sol",
        category: "accesorios",
        price: 44.99,
        image: "🕶️",
        description: "Protección y estilo"
    },
    {
        id: 10,
        name: "Sombrero Elegante",
        category: "accesorios",
        price: 34.99,
        image: "🎩",
        description: "Completa tu outfit"
    },
    {
        id: 11,
        name: "Pantalón Chino",
        category: "hombres",
        price: 54.99,
        image: "👖",
        description: "Cómodo para el trabajo"
    },
    {
        id: 12,
        name: "Sudadera Gris",
        category: "hombres",
        price: 49.99,
        image: "🧤",
        description: "Perfecta para el frío"
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
            <div class="product-image">${product.image}</div>
            <div class="product-info">
                <div class="product-category">${product.category}</div>
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