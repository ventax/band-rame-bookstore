import './bootstrap';

import Alpine from 'alpinejs';
import AOS from 'aos';
import 'aos/dist/aos.css';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import Typed from 'typed.js';
import 'particles.js';
import confetti from 'canvas-confetti';
import Swal from 'sweetalert2';
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

window.Alpine = Alpine;
window.AOS = AOS;
window.gsap = gsap;
window.Typed = Typed;
window.confetti = confetti;
window.Swal = Swal;
window.Swiper = Swiper;

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger);

Alpine.start();

// ========================================
// FLY TO CART ANIMATION
// ========================================
window.flyToCart = function(element, productName = 'Produk') {
    // Get cart icon element
    const cartIcon = document.querySelector('#cart-icon') || document.querySelector('[id*="cart"]');

    if (!cartIcon) {
        // Fallback jika cart icon tidak ditemukan
        showToast('success', `${productName} ditambahkan ke keranjang!`);
        confetti({
            particleCount: 50,
            spread: 60,
            origin: { y: 0.7 }
        });
        return;
    }

    // Get positions
    const itemRect = element.getBoundingClientRect();
    const cartRect = cartIcon.getBoundingClientRect();

    // Clone the clicked element
    const clone = element.cloneNode(true);
    clone.style.cssText = `
        position: fixed;
        top: ${itemRect.top}px;
        left: ${itemRect.left}px;
        width: ${itemRect.width}px;
        height: ${itemRect.height}px;
        z-index: 9999;
        pointer-events: none;
        transition: none;
    `;
    document.body.appendChild(clone);

    // Animate to cart
    gsap.to(clone, {
        duration: 0.8,
        x: cartRect.left - itemRect.left + cartRect.width / 2,
        y: cartRect.top - itemRect.top + cartRect.height / 2,
        scale: 0.1,
        opacity: 0.8,
        ease: 'power2.inOut',
        onComplete: () => {
            // Remove clone
            clone.remove();

            // Cart icon bounce animation
            gsap.fromTo(cartIcon,
                { scale: 1 },
                {
                    scale: 1.3,
                    duration: 0.2,
                    yoyo: true,
                    repeat: 1,
                    ease: 'power2.inOut'
                }
            );

            // Mini confetti burst at cart
            confetti({
                particleCount: 30,
                spread: 50,
                origin: {
                    x: (cartRect.left + cartRect.width / 2) / window.innerWidth,
                    y: (cartRect.top + cartRect.height / 2) / window.innerHeight
                },
                colors: ['#a855f7', '#ec4899', '#3b82f6']
            });

            // Update cart count with animation
            updateCartCount();

            // Show success toast
            showToast('success', `${productName} berhasil ditambahkan!`);
        }
    });
};

// Update cart count with animation
function updateCartCount(increment = true) {
    const cartCountEl = document.getElementById('cart-count');
    if (cartCountEl) {
        const currentCount = parseInt(cartCountEl.textContent) || 0;
        const newCount = increment ? currentCount + 1 : Math.max(0, currentCount - 1);

        cartCountEl.textContent = newCount;

        // Pulse animation
        gsap.fromTo(cartCountEl,
            { scale: 1 },
            {
                scale: 1.5,
                duration: 0.2,
                yoyo: true,
                repeat: 1,
                ease: 'power2.inOut'
            }
        );
    }
}

// ========================================
// FLY TO WISHLIST ANIMATION
// ========================================
window.flyToWishlist = function(element, productName = 'Produk') {
    const wishlistIcon = document.querySelector('[href*="wishlist"]') || document.querySelector('.wishlist-icon');

    if (wishlistIcon) {
        const itemRect = element.getBoundingClientRect();
        const wishRect = wishlistIcon.getBoundingClientRect();

        // Create heart element
        const heart = document.createElement('div');
        heart.innerHTML = '<i class="fas fa-heart text-red-500 text-4xl"></i>';
        heart.style.cssText = `
            position: fixed;
            top: ${itemRect.top + itemRect.height / 2}px;
            left: ${itemRect.left + itemRect.width / 2}px;
            z-index: 9999;
            pointer-events: none;
        `;
        document.body.appendChild(heart);

        // Animate to wishlist
        gsap.to(heart, {
            duration: 1,
            x: wishRect.left - itemRect.left - itemRect.width / 2,
            y: wishRect.top - itemRect.top - itemRect.height / 2,
            scale: 0.2,
            opacity: 0,
            ease: 'power2.inOut',
            onComplete: () => {
                heart.remove();

                // Wishlist icon animation
                gsap.fromTo(wishlistIcon,
                    { scale: 1 },
                    {
                        scale: 1.3,
                        duration: 0.2,
                        yoyo: true,
                        repeat: 1,
                        ease: 'elastic.out(1, 0.3)'
                    }
                );

                showToast('success', `${productName} ditambahkan ke wishlist! ❤️`);
            }
        });
    } else {
        showToast('success', `${productName} ditambahkan ke wishlist! ❤️`);
    }
};

// ========================================
// TOAST NOTIFICATIONS
// ========================================
window.showToast = function(type = 'success', message = 'Berhasil!', duration = 3000) {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: duration,
        timerProgressBar: true,
        width: 'auto',
        padding: '0.75rem 1rem',
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        },
        customClass: {
            popup: 'colored-toast'
        }
    });

    const icons = {
        success: '✅',
        error: '❌',
        warning: '⚠️',
        info: 'ℹ️'
    };

    Toast.fire({
        icon: type,
        title: message,
        iconHtml: icons[type] || icons.success
    });
};

// ========================================
// CELEBRATION EFFECTS
// ========================================
window.celebrateCheckout = function() {
    // Big confetti burst
    const duration = 3 * 1000;
    const animationEnd = Date.now() + duration;
    const defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 9999 };

    function randomInRange(min, max) {
        return Math.random() * (max - min) + min;
    }

    const interval = setInterval(function() {
        const timeLeft = animationEnd - Date.now();

        if (timeLeft <= 0) {
            return clearInterval(interval);
        }

        const particleCount = 50 * (timeLeft / duration);

        confetti({
            ...defaults,
            particleCount,
            origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 }
        });
        confetti({
            ...defaults,
            particleCount,
            origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 }
        });
    }, 250);

    // Success message
    Swal.fire({
        title: '🎉 Terima Kasih!',
        text: 'Pesanan Anda sedang diproses',
        icon: 'success',
        confirmButtonText: 'OK',
        confirmButtonColor: '#a855f7',
        timer: 5000
    });
};

// ========================================
// AOS INITIALIZATION
// ========================================
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        easing: 'ease-in-out-cubic',
        once: false,
        mirror: true,
        offset: 100
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Parallax effect on scroll
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('[data-parallax]');

        parallaxElements.forEach(element => {
            const speed = element.dataset.parallax || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });

    // ========================================
    // GSAP ANIMATIONS
    // ========================================

    // Float animation for decorative elements
    gsap.utils.toArray('.float-animation').forEach(element => {
        gsap.to(element, {
            y: -20,
            duration: 2,
            ease: 'power1.inOut',
            yoyo: true,
            repeat: -1
        });
    });

    // Rotate animation
    gsap.utils.toArray('.rotate-slow').forEach(element => {
        gsap.to(element, {
            rotation: 360,
            duration: 20,
            ease: 'none',
            repeat: -1
        });
    });

    // ========================================
    // CUSTOM CURSOR EFFECT
    // ========================================
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    cursor.style.cssText = `
        width: 20px;
        height: 20px;
        border: 2px solid #a855f7;
        border-radius: 50%;
        position: fixed;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.2s ease, opacity 0.3s ease;
        opacity: 0;
        mix-blend-mode: difference;
    `;
    document.body.appendChild(cursor);

    document.addEventListener('mousemove', (e) => {
        cursor.style.left = e.clientX - 10 + 'px';
        cursor.style.top = e.clientY - 10 + 'px';
        cursor.style.opacity = '1';
    });

    document.addEventListener('mouseleave', () => {
        cursor.style.opacity = '0';
    });

    // Magnetic effect on buttons
    document.querySelectorAll('button, a').forEach(button => {
        button.addEventListener('mouseenter', () => {
            cursor.style.transform = 'scale(2)';
            cursor.style.borderColor = '#ec4899';
        });

        button.addEventListener('mouseleave', () => {
            cursor.style.transform = 'scale(1)';
            cursor.style.borderColor = '#a855f7';
        });
    });

    // ========================================
    // TYPEWRITER EFFECT (if element exists)
    // ========================================
    const typewriterElement = document.querySelector('.typewriter-effect');
    if (typewriterElement) {
        new Typed('.typewriter-effect', {
            strings: [
                'Selamat datang di BandRame! 📚',
                'Temukan buku favoritmu! ✨',
                'Raih mimpimu dengan membaca! 🌟'
            ],
            typeSpeed: 50,
            backSpeed: 30,
            loop: true,
            backDelay: 1500,
            startDelay: 500
        });
    }

    // ========================================
    // PARTICLES BACKGROUND (if container exists)
    // ========================================
    if (typeof particlesJS !== 'undefined' && document.getElementById('particles-js')) {
        particlesJS('particles-js', {
            particles: {
                number: { value: 80, density: { enable: true, value_area: 800 } },
                color: { value: ['#a855f7', '#ec4899', '#3b82f6'] },
                shape: { type: 'circle' },
                opacity: { value: 0.5, random: true },
                size: { value: 3, random: true },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#a855f7',
                    opacity: 0.2,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2,
                    direction: 'none',
                    random: true,
                    straight: false,
                    out_mode: 'out',
                    bounce: false
                }
            },
            interactivity: {
                detect_on: 'canvas',
                events: {
                    onhover: { enable: true, mode: 'grab' },
                    onclick: { enable: true, mode: 'push' },
                    resize: true
                },
                modes: {
                    grab: { distance: 140, line_linked: { opacity: 1 } },
                    push: { particles_nb: 4 }
                }
            },
            retina_detect: true
        });
    }
});

// Initialize AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', function() {
    AOS.init({
        duration: 1000,
        easing: 'ease-out-cubic',
        once: false,
        offset: 100,
        delay: 100,
        disable: false,
        startEvent: 'DOMContentLoaded',
        animatedClassName: 'aos-animate',
    });

    // Refresh AOS on window resize
    window.addEventListener('resize', () => {
        AOS.refresh();
    });

    // Smooth scroll behavior
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = this.getAttribute('href');
            if (target !== '#') {
                e.preventDefault();
                const element = document.querySelector(target);
                if (element) {
                    element.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });

    // Parallax effect untuk hero elements
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    if (parallaxElements.length > 0) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            parallaxElements.forEach(el => {
                const speed = el.dataset.parallax || 0.5;
                el.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });
    }

    // Floating animation untuk decorative elements
    const floatingElements = document.querySelectorAll('.floating');
    floatingElements.forEach((el, index) => {
        gsap.to(el, {
            y: -20,
            duration: 2 + (index * 0.3),
            repeat: -1,
            yoyo: true,
            ease: 'power1.inOut'
        });
    });

    // Cursor follow effect
    const cursor = document.createElement('div');
    cursor.className = 'custom-cursor';
    cursor.style.cssText = `
        position: fixed;
        width: 20px;
        height: 20px;
        border: 2px solid #a855f7;
        border-radius: 50%;
        pointer-events: none;
        z-index: 9999;
        transition: transform 0.2s ease;
        display: none;
    `;
    document.body.appendChild(cursor);

    let mouseX = 0, mouseY = 0;
    let cursorX = 0, cursorY = 0;

    document.addEventListener('mousemove', (e) => {
        mouseX = e.clientX;
        mouseY = e.clientY;
        cursor.style.display = 'block';
    });

    function animateCursor() {
        cursorX += (mouseX - cursorX) * 0.1;
        cursorY += (mouseY - cursorY) * 0.1;
        cursor.style.left = cursorX + 'px';
        cursor.style.top = cursorY + 'px';
        requestAnimationFrame(animateCursor);
    }
    animateCursor();

    // Scale effect on hover
    document.querySelectorAll('a, button').forEach(el => {
        el.addEventListener('mouseenter', () => {
            cursor.style.transform = 'scale(2)';
            cursor.style.borderColor = '#ec4899';
        });
        el.addEventListener('mouseleave', () => {
            cursor.style.transform = 'scale(1)';
            cursor.style.borderColor = '#a855f7';
        });
    });

    // ========================================
    // HERO IMAGE SLIDER
    // ========================================
    if (document.querySelector('.hero-swiper')) {
        new Swiper('.hero-swiper', {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            speed: 800,
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
                renderBullet: function (index, className) {
                    return '<span class="' + className + '"></span>';
                },
            },
        });
    }
});

