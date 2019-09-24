<template>
  <div class="card">
    <div class="card-heading">
      <div class="card-body">
        <slot></slot>
        <h4 class="card-title"> <span>{{title}}</span> </h4>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  name: "CardCustom",
  props:['title']
}
</script>
