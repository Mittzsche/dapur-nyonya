<template>
  <div class="admin-layout">
    <Sidebar :is-open="isSidebarOpen" @close="isSidebarOpen = false" />
    
    <main class="main-content">
      <Header 
        :title="title" 
        @toggle-sidebar="isSidebarOpen = !isSidebarOpen"
      >
        <template #actions>
          <slot name="header-actions"></slot>
        </template>
      </Header>

      <div class="content">
        <slot></slot>
      </div>
    </main>
  </div>
</template>

<script>
import Sidebar from '@/components/admin/Sidebar.vue'
import Header from '@/components/admin/Header.vue'

export default {
  name: 'AdminLayout',
  components: {
    Sidebar,
    Header
  },
  props: {
    title: {
      type: String,
      default: 'Admin Panel'
    }
  },
  data() {
    return {
      isSidebarOpen: false
    }
  }
}
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #f5f5f5;
}

.main-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  margin-left: 250px; /* Offset for fixed sidebar */
  transition: margin-left 0.3s ease;
  min-width: 0; /* Prevent flex child overflow */
}

.content {
  padding: 2rem;
  flex: 1;
}

@media (max-width: 992px) {
  .main-content {
    margin-left: 0; /* Full width on mobile when sidebar is hidden */
  }
  
  .content {
    padding: 1rem;
  }
}
</style>
