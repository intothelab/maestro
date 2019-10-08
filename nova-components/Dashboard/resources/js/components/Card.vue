<template>
    <div class="card relative">
        <div class="px-6 py-4">
            <slot></slot>
        </div>
    </div>
</template>
<script>
export default {
  name: "CardCustom",
  props: ['title']
}
</script>
