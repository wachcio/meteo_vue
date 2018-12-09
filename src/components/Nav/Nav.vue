<template>
  <nav>
    <div class="container">
      <div class="item refresh">Odśwież dane</div>
      <div class="item current active">Odczyty aktualne</div>
      <div class="item archive">Odczyty archiwalne</div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "Nav"
};
</script>

<style type="scss">
nav {
  display: flex;
  justify-content: center;
  position: relative;
  left: 0;
  top: 0;
  width: 100%;
  margin-top: 17px;
}

.container {
  display: flex;
  justify-content: space-between;
}

.item {
  width: 200px;
  background-color: #01335c;
  color: #c7eafd;
  padding: 15px 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  margin: 5px 20px;
  text-align: center;
}

.item:hover,
.active {
  background-color: #68bafb;
}
</style>
