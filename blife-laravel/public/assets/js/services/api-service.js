class ApiService {
  constructor() {
    this.config = null;
    this.loadConfig();
  }

  async loadConfig() {
    try {
      const response = await fetch('data/api-config.json');
      this.config = await response.json();
    } catch (error) {
      console.error('Failed to load API config:', error);
      // Fallback to mockup data
      this.config = {
        baseUrl: '',
        endpoints: {},
        auth: { token: '', type: 'Bearer' },
        timeout: 10000,
        retry: { attempts: 3, delay: 1000 }
      };
    }
  }

  async request(endpoint, options = {}) {
    if (!this.config) await this.loadConfig();

    const url = this.config.baseUrl + this.config.endpoints[endpoint];
    const headers = {
      'Content-Type': 'application/json',
      ...options.headers
    };

    if (this.config.auth.token) {
      headers['Authorization'] = `${this.config.auth.type} ${this.config.auth.token}`;
    }

    const requestOptions = {
      ...options,
      headers
    };

    let attempts = 0;
    const maxAttempts = this.config.retry.attempts;

    while (attempts < maxAttempts) {
      try {
        const response = await fetch(url, requestOptions);
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return await response.json();
      } catch (error) {
        attempts++;
        if (attempts >= maxAttempts) {
          console.error(`API request failed after ${maxAttempts} attempts:`, error);
          // Fallback to mockup data
          return this.getMockupData(endpoint);
        }
        await new Promise(resolve => setTimeout(resolve, this.config.retry.delay));
      }
    }
  }

  async get(endpoint, params = {}) {
    const queryString = new URLSearchParams(params).toString();
    const url = queryString ? `${endpoint}?${queryString}` : endpoint;
    return this.request(url, { method: 'GET' });
  }

  async post(endpoint, data) {
    return this.request(endpoint, {
      method: 'POST',
      body: JSON.stringify(data)
    });
  }

  async put(endpoint, data) {
    return this.request(endpoint, {
      method: 'PUT',
      body: JSON.stringify(data)
    });
  }

  async delete(endpoint) {
    return this.request(endpoint, { method: 'DELETE' });
  }

  // Fallback to mockup data when API is unavailable
  async getMockupData(endpoint) {
    try {
      const response = await fetch('data/mockup-data.json');
      const mockupData = await response.json();

      switch (endpoint) {
        case 'users':
          return mockupData.users;
        case 'products':
          return mockupData.products;
        case 'categories':
          return mockupData.categories;
        case 'orders':
          return mockupData.orders;
        case 'attributes':
          return mockupData.attributes;
        default:
          return [];
      }
    } catch (error) {
      console.error('Failed to load mockup data:', error);
      return [];
    }
  }

  // Specific methods for common operations
  async getUsers() {
    return this.get('users');
  }

  async createUser(userData) {
    return this.post('users', userData);
  }

  async updateUser(userId, userData) {
    return this.put(`users/${userId}`, userData);
  }

  async deleteUser(userId) {
    return this.delete(`users/${userId}`);
  }

  async getProducts() {
    return this.get('products');
  }

  async createProduct(productData) {
    return this.post('products', productData);
  }

  async updateProduct(productId, productData) {
    return this.put(`products/${productId}`, productData);
  }

  async deleteProduct(productId) {
    return this.delete(`products/${productId}`);
  }

  async getCategories() {
    return this.get('categories');
  }

  async createCategory(categoryData) {
    return this.post('categories', categoryData);
  }

  async updateCategory(categoryId, categoryData) {
    return this.put(`categories/${categoryId}`, categoryData);
  }

  async deleteCategory(categoryId) {
    return this.delete(`categories/${categoryId}`);
  }

  async getOrders() {
    return this.get('orders');
  }

  async createOrder(orderData) {
    return this.post('orders', orderData);
  }

  async updateOrder(orderId, orderData) {
    return this.put(`orders/${orderId}`, orderData);
  }

  async deleteOrder(orderId) {
    return this.delete(`orders/${orderId}`);
  }

  async getAttributes() {
    return this.get('attributes');
  }

  async createAttribute(attributeData) {
    return this.post('attributes', attributeData);
  }

  async updateAttribute(attributeId, attributeData) {
    return this.put(`attributes/${attributeId}`, attributeData);
  }

  async deleteAttribute(attributeId) {
    return this.delete(`attributes/${attributeId}`);
  }

  async getRoles() {
    return this.get('roles');
  }

  async createRole(roleData) {
    return this.post('roles', roleData);
  }

  async updateRole(roleId, roleData) {
    return this.put(`roles/${roleId}`, roleData);
  }

  async deleteRole(roleId) {
    return this.delete(`roles/${roleId}`);
  }

  async getPermissions() {
    return this.get('permissions');
  }
}

// Create global instance
const apiService = new ApiService();
