<template>
  <v-toolbar>
    <!-- <v-toolbar-side-icon></v-toolbar-side-icon> -->
    <v-toolbar-title>Title</v-toolbar-title>
    <v-spacer></v-spacer>
    <v-toolbar-items class="hidden-sm-and-down">
      <v-btn flat  to="/">Home</v-btn>
      <v-btn flat to="/new">Nya Ordrar</v-btn>
      <v-btn flat to="/archive">Gamla Ordrar</v-btn>
    </v-toolbar-items>
  </v-toolbar>
</template>