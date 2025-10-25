/**
 * App Initializer - จัดการการเริ่มต้นแอปพลิเคชัน
 * รวมการโหลด services และการตั้งค่าเริ่มต้น
 */
class AppInitializer {
  constructor() {
    this.services = {};
    this.initialized = false;
  }

  /**
   * เริ่มต้นแอปพลิเคชัน
   */
  async initialize() {
    try {
      console.log('Initializing Blife Admin Application...');

      // เริ่มต้น Config Manager ก่อน
      await this.initializeConfigManager();

      // เริ่มต้น Translation Service
      await this.initializeTranslationService();

      // เริ่มต้น API Service
      await this.initializeApiService();

      // เริ่มต้น Data Controller
      await this.initializeDataController();

      // เริ่มต้น Role Management
      await this.initializeRoleManagement();

      // ตั้งค่า UI และ Events
      this.setupUI();
      this.setupEventListeners();

      this.initialized = true;
      console.log('Blife Admin Application initialized successfully');

      // แสดงข้อความต้อนรับ
      this.showWelcomeMessage();

      return true;
    } catch (error) {
      console.error('Failed to initialize application:', error);
      this.showInitializationError(error);
      return false;
    }
  }

  /**
   * เริ่มต้น Config Manager
   */
  async initializeConfigManager() {
    if (typeof ConfigManager === 'undefined') {
      throw new Error('ConfigManager not loaded');
    }

    this.services.configManager = window.ConfigManager;
    const success = await this.services.configManager.initialize();

    if (!success) {
      throw new Error('Failed to initialize Config Manager');
    }
  }

  /**
   * เริ่มต้น Translation Service
   */
  async initializeTranslationService() {
    if (typeof TranslationService === 'undefined') {
      throw new Error('TranslationService not loaded');
    }

    this.services.translationService = new TranslationService();
    const success = await this.services.translationService.initialize();

    if (!success) {
      throw new Error('Failed to initialize Translation Service');
    }
  }

  /**
   * เริ่มต้น API Service
   */
  async initializeApiService() {
    if (typeof ApiService === 'undefined') {
      throw new Error('ApiService not loaded');
    }

    this.services.apiService = new ApiService();
    const success = await this.services.apiService.initialize();

    if (!success) {
      throw new Error('Failed to initialize API Service');
    }
  }

  /**
   * เริ่มต้น Data Controller
   */
  async initializeDataController() {
    if (typeof DataController === 'undefined') {
      throw new Error('DataController not loaded');
    }

    this.services.dataController = window.DataController;
    const success = await this.services.dataController.initialize(
      this.services.apiService,
      this.services.translationService
    );

    if (!success) {
      throw new Error('Failed to initialize Data Controller');
    }
  }

  /**
   * เริ่มต้น Role Management
   */
  async initializeRoleManagement() {
    if (typeof RoleManagement === 'undefined') {
      throw new Error('RoleManagement not loaded');
    }

    this.services.roleManagement = new RoleManagement();
    const success = await this.services.roleManagement.initialize();

    if (!success) {
      throw new Error('Failed to initialize Role Management');
    }
  }

  /**
   * ตั้งค่า UI เริ่มต้น
   */
  setupUI() {
    // ตั้งค่าภาษาเริ่มต้น
    this.setDefaultLanguage();

    // ตั้งค่า theme
    this.applyTheme();

    // ซ่อน loading screen
    this.hideLoadingScreen();

    // แสดง main content
    this.showMainContent();
  }

  /**
   * ตั้งค่า Event Listeners
   */
  setupEventListeners() {
    // Language switcher
    const languageSwitcher = document.getElementById('languageSwitcher');
    if (languageSwitcher) {
      languageSwitcher.addEventListener('change', (e) => {
        this.changeLanguage(e.target.value);
      });
    }

    // Theme switcher
    const themeSwitcher = document.getElementById('themeSwitcher');
    if (themeSwitcher) {
      themeSwitcher.addEventListener('change', (e) => {
        this.changeTheme(e.target.value);
      });
    }

    // Logout handler
    const logoutBtn = document.getElementById('logoutBtn');
    if (logoutBtn) {
      logoutBtn.addEventListener('click', () => {
        this.handleLogout();
      });
    }
  }

  /**
   * ตั้งค่าภาษาเริ่มต้น
   */
  setDefaultLanguage() {
    const savedLanguage = localStorage.getItem('selectedLanguage') || 'th';
    this.services.translationService.setLanguage(savedLanguage);

    const languageSwitcher = document.getElementById('languageSwitcher');
    if (languageSwitcher) {
      languageSwitcher.value = savedLanguage;
    }
  }

  /**
   * ใช้ theme
   */
  applyTheme() {
    const savedTheme = localStorage.getItem('selectedTheme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);

    const themeSwitcher = document.getElementById('themeSwitcher');
    if (themeSwitcher) {
      themeSwitcher.value = savedTheme;
    }
  }

  /**
   * เปลี่ยนภาษา
   */
  async changeLanguage(language) {
    try {
      await this.services.translationService.setLanguage(language);
      localStorage.setItem('selectedLanguage', language);

      // รีโหลดหน้าเพื่อใช้ภาษาใหม่
      window.location.reload();
    } catch (error) {
      console.error('Failed to change language:', error);
    }
  }

  /**
   * เปลี่ยน theme
   */
  changeTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('selectedTheme', theme);
  }

  /**
   * จัดการการออกจากระบบ
   */
  handleLogout() {
    if (confirm(this.services.translationService.translate('confirm_logout'))) {
      // ล้าง session data
      localStorage.removeItem('userToken');
      localStorage.removeItem('userRole');

      // เปลี่ยนไปหน้า login
      window.location.href = '/login.html';
    }
  }

  /**
   * ซ่อน loading screen
   */
  hideLoadingScreen() {
    const loadingScreen = document.getElementById('loadingScreen');
    if (loadingScreen) {
      loadingScreen.style.display = 'none';
    }
  }

  /**
   * แสดง main content
   */
  showMainContent() {
    const mainContent = document.getElementById('mainContent');
    if (mainContent) {
      mainContent.style.display = 'block';
    }
  }

  /**
   * แสดงข้อความต้อนรับ
   */
  showWelcomeMessage() {
    const companyInfo = this.services.configManager.getCompanyInfo();
    const welcomeMessage = `ยินดีต้อนรับสู่ ${companyInfo.name_th || companyInfo.name}`;

    // แสดง toast หรือ notification
    this.showNotification(welcomeMessage, 'success');
  }

  /**
   * แสดงข้อผิดพลาดในการเริ่มต้น
   */
  showInitializationError(error) {
    const errorMessage = `เกิดข้อผิดพลาดในการเริ่มต้นระบบ: ${error.message}`;
    console.error(errorMessage);

    this.showNotification(errorMessage, 'error');

    // แสดง error screen
    const errorScreen = document.getElementById('errorScreen');
    if (errorScreen) {
      errorScreen.style.display = 'block';
      errorScreen.innerHTML = `
        <div class="error-container">
          <h2>เกิดข้อผิดพลาด</h2>
          <p>${errorMessage}</p>
          <button onclick="window.location.reload()">ลองใหม่</button>
        </div>
      `;
    }
  }

  /**
   * แสดง notification
   */
  showNotification(message, type = 'info') {
    // สร้าง notification element
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.innerHTML = `
      <span>${message}</span>
      <button class="notification-close">&times;</button>
    `;

    // เพิ่มใน DOM
    document.body.appendChild(notification);

    // ตั้งค่า auto hide
    setTimeout(() => {
      notification.remove();
    }, 5000);

    // ปุ่มปิด
    notification.querySelector('.notification-close').addEventListener('click', () => {
      notification.remove();
    });
  }

  /**
   * รับ services
   */
  getService(serviceName) {
    return this.services[serviceName];
  }

  /**
   * ตรวจสอบว่าการเริ่มต้นเสร็จสิ้นหรือไม่
   */
  isInitialized() {
    return this.initialized;
  }
}

// สร้าง instance กลาง
const appInitializer = new AppInitializer();

// ส่งออกสำหรับการใช้งาน
window.AppInitializer = appInitializer;

// เริ่มต้นแอปพลิเคชันเมื่อ DOM โหลดเสร็จ
document.addEventListener('DOMContentLoaded', async () => {
  await appInitializer.initialize();
});
