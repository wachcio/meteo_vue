<template>
  <transition
    mode="out-in"
    :appear="appear"
    :enter-active-class="'animated ' + enter"
    :leave-active-class="'animated ' + leave"
  >
    <slot></slot>
  </transition>
</template>

<script>
export default {
  name: "AnimateCSS",
  props: ["appear", "enter", "leave"],
  data() {
    return {};
  }
};
</script>

