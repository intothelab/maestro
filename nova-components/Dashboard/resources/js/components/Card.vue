<template>
    <div class="bg-20 rounded overflow-hidden shadow-lg relative">
        <div class="px-6 py-4">
            <div v-if="title" class="font-bold text-xl mb-2">{{title}}</div>
            <p class="text-gray-700 text-base">
                <slot></slot>
            </p>
        </div>
    </div>
</template>
<script>
export default {
  name: "CardCustom",
  props:['title']
}
</script>
