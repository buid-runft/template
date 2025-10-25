/**
 * Data Controller - จัดการข้อมูลทั้งหมดของระบบ
 * รวม mockup data, API data, และ caching
 */
class DataController {
  constructor() {
    this.cache = new Map();
    this.cacheTimeout = 5 * 60 * 1000; // 5 นาที
    this.mockupData = null;
    this.apiService = null;
    this.translationService = null;
  }

  /**
   * เริ่มต้น Data Controller
   */
  async initialize(apiService, translationService) {
    this.apiService = apiService;
    this.translationService = translationService;

    try {
      // โหลด mockup data
      const response = await fetch('/dashbord-admin/data/mockup-data.json');
      this.mockupData = await response.json();

      console.log('Data Controller initialized successfully');
      return true;
    } catch (error) {
      console.error('Failed to initialize Data Controller:', error);
      return false;
    }
  }

  /**
   * รับข้อมูลผู้ใช้
   */
  async getUsers(filters = {}) {
    const cacheKey = `users_${JSON.stringify(filters)}`;

    if (this.isCacheValid(cacheKey)) {
      return this.getCachedData(cacheKey);
    }

    try {
      let users = await this.apiService.get('/users', filters);

      // ถ้า API ไม่พร้อม ใช้ mockup data
      if (!users || users.length === 0) {
        users = this.mockupData.users || [];
      }

      // กรองข้อมูลตาม filters
      if (filters.role) {
        users = users.filter(user => user.role === filters.role);
      }

      if (filters.status) {
        users = users.filter(user => user.status === filters.status);
      }

      // แปลข้อมูล
      users = users.map(user => this.translateUserData(user));

      this.setCache(cacheKey, users);
      return users;
    } catch (error) {
      console.error('Failed to get users:', error);
      return this.mockupData.users || [];
    }
  }

  /**
   * รับข้อมูลสินค้า
   */
  async getProducts(filters = {}) {
    const cacheKey = `products_${JSON.stringify(filters)}`;

    if (this.isCacheValid(cacheKey)) {
      return this.getCachedData(cacheKey);
    }

    try {
      let products = await this.apiService.get('/products', filters);

      // ถ้า API ไม่พร้อม ใช้ mockup data
      if (!products || products.length === 0) {
        products = this.mockupData.products || [];
      }

      // กรองข้อมูลตาม filters
      if (filters.category) {
        products = products.filter(product => product.category === filters.category);
      }

      if (filters.vendor_id) {
        products = products.filter(product => product.vendor_id === filters.vendor_id);
      }

      if (filters.status) {
        products = products.filter(product => product.status === filters.status);
      }

      // แปลข้อมูล
      products = products.map(product => this.translateProductData(product));

      this.setCache(cacheKey, products);
      return products;
    } catch (error) {
      console.error('Failed to get products:', error);
      return this.mockupData.products || [];
    }
  }

  /**
   * รับข้อมูลคำสั่งซื้อ
   */
  async getOrders(filters = {}) {
    const cacheKey = `orders_${JSON.stringify(filters)}`;

    if (this.isCacheValid(cacheKey)) {
      return this.getCachedData(cacheKey);
    }

    try {
      let orders = await this.apiService.get('/orders', filters);

      // ถ้า API ไม่พร้อม ใช้ mockup data
      if (!orders || orders.length === 0) {
        orders = this.mockupData.orders || [];
      }

      // กรองข้อมูลตาม filters
