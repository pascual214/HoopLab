<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'

const words = ['juego', 'rendimiento', 'futuro']
const currentWord = ref(words[0])
const animating = ref(false)
const wordRef = ref(null)
const containerWidth = ref('auto')
let interval

async function updateWidth() {
    await nextTick()
    if (wordRef.value) {
        containerWidth.value = wordRef.value.scrollWidth + 'px'
    }
}

onMounted(async () => {
    await updateWidth()
    let index = 0

    interval = setInterval(() => {
        animating.value = true
        setTimeout(async () => {
            index = (index + 1) % words.length
            currentWord.value = words[index]
            animating.value = false
            await updateWidth()
        }, 800)
    }, 3000)
})

onUnmounted(() => clearInterval(interval))
</script>

<template>
    <div
        class="hero min-h-screen bg-cover bg-center relative"
        style="background-image: url('/images/background/Pizarra.png');"
    >
        <div class="absolute inset-0 bg-linear-to-b from-black/10 via-black/50 to-black/80"></div>
        
        <div class="hero-content text-neutral-content text-center relative z-10">
            <div class="max-w-4xl">
                <h1 class="pb-10 text-5xl font-bold text-white drop-shadow-lg">
                    Sube tu nivel,
                    <br>
                    transforma tu&nbsp;<div
                        class="word-wrapper"
                        :style="{ width: containerWidth }"
                    >
                        <span
                            class="rotating-word"
                            :class="{ exit: animating, enter: !animating }"
                            ref="wordRef"
                        >{{ currentWord }}</span>
                    </div>
                </h1>
                <p class="mb-5 font-semibold text-white/90 drop-shadow-md">
                    Crea tus entrenamientos para todas las edades y niveles. <br> 
                    Guárdalos y compártelos con amigos, entrenadores o compañeros.
                </p>
                <button type="button" class="text-white bg-linear-to-br from-purple-400 to-blue-800 hover:bg-linear-to-bl focus:ring-1 focus:outline-none focus:ring-white dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
                    Empezar ahora
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.word-wrapper {
    display: inline-block;
    vertical-align: baseline;
    transition: width 0.8s cubic-bezier(0.16, 1, 0.3, 1);
}

.rotating-word {
    display: inline-block;
    color: rgb(255, 119, 0);
    white-space: nowrap;
    transition: clip-path 2s cubic-bezier(0.16, 1, 0.3, 1),
                opacity 2s cubic-bezier(0.16, 1, 0.3, 1);
    clip-path: inset(0 0% 0 0);
    opacity: 1;
    padding-bottom: 8px;
    margin-bottom: -8px;
}

.rotating-word.exit {
    clip-path: inset(0 100% 0 0);
    opacity: 0;
}

.rotating-word.enter {
    clip-path: inset(0 0% 0 0);
    opacity: 1;
}
</style>