<template>
    <div class="basketball-lines-container">
        <svg 
        xmlns="http://www.w3.org/2000/svg" 
        viewBox="0 0 100 100" 
        class="basketball-lines-svg"
        role="img" 
        aria-label="Pelota de baloncesto"
        >
            <circle 
                cx="50" 
                cy="50" 
                r="46" 
                fill="none"
                class="animated-lines outer-circle"
            />
            
            <g 
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="animated-lines inner-lines"
            >
                <path d="M6 50 H94" />
                <path d="M50 6 V94" />
                
                <path d="M20 20 C35 35, 35 65, 20 80" />
                <path d="M80 20 C65 35, 65 65, 80 80" />
            </g>
        </svg>
    </div>
</template>

<style scoped>
.basketball-lines-svg {
    width: 35px;
    height: 35px;
    overflow: visible; 
    filter: drop-shadow(0 1px 2px rgba(0,0,0,0.2));
}

.animated-lines {
    stroke-width: 8px; 
    animation: changeColor 3s infinite ease-in-out;
}

@keyframes changeColor {
    0%, 50% { stroke: oklch(70% 0.2 50); }
    15% { stroke: oklch(42.4% 0.199 265.638); }
    35% { stroke: oklch(42.4% 0.199 265.638); }
    100% { stroke: oklch(70% 0.2 50); }
}
</style>