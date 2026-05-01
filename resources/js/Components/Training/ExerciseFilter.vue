<script setup>
import { ref, computed, watch } from "vue";

const props = defineProps({
    mode: {
        type: String,
        required: true,
    },
    availableTypes: {
        type: Array,
        default: () => [],
    },
});

const filterType = ref("");
const filterValue = ref("");

const difficultyOptions = ["facil", "intermedio", "dificil"];

const emit = defineEmits(["filter-change"]);

const filterOptions = computed(() => {
    if (filterType.value === "tipo") {
        return props.availableTypes;
    } else if (filterType.value === "dificultad") {
        return difficultyOptions;
    }
    return [];
});

// Resetear filtros cuando cambia el modo
watch(() => props.mode, () => {
    filterType.value = "";
    filterValue.value = "";
    emitFilter();
});

const handleFilterTypeChange = () => {
    filterValue.value = "";
    emitFilter();
};

const handleFilterValueChange = () => {
    emitFilter();
};

const emitFilter = () => {
    emit("filter-change", {
        filterType: filterType.value,
        filterValue: filterValue.value,
    });
};

const resetFilters = () => {
    filterType.value = "";
    filterValue.value = "";
    emitFilter();
};
</script>

<template>
    <div class="flex gap-2 items-center">
        <!-- Primera selección: Tipo o Dificultad -->
        <select
            id="filter-type"
            v-model="filterType"
            @change="handleFilterTypeChange"
            class="px-2 py-1.5 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-transparent border border-gray-400"
        >
            <option value="">Selecciona una opción</option>
            <option value="tipo">Tipo</option>
            <option value="dificultad">Dificultad</option>
        </select>

        <!-- Segunda selección: Dinámicas según la primera -->
        <select
            id="filter-value"
            v-model="filterValue"
            @change="handleFilterValueChange"
            :disabled="!filterType"
            class="px-2 py-1.5 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 disabled:cursor-not-allowed disabled:text-gray-400 bg-transparent border border-gray-400"
        >
            <option value="">Selecciona una opción</option>
            <option
                v-for="option in filterOptions"
                :key="option"
                :value="option"
            >
                {{ option.charAt(0).toUpperCase() + option.slice(1) }}
            </option>
        </select>

        <!-- Botón para limpiar filtros -->
        <button
            @click="resetFilters"
            class="px-3 py-1.5 text-gray-800 font-medium rounded-md text-sm transition-colors duration-200 hover:bg-gray-200"
        >
            Limpiar
        </button>
    </div>
</template>
