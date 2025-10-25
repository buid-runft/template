/**
 * Config Manager - จัดการการตั้งค่าทั้งหมดของระบบ
 * รวม business config, API config, และ theme settings
 */
class ConfigManager {
  constructor() {
    this.businessConfig = null;
    this.apiConfig = null;
    this.themeConfig = null;
    this.initialized = false;
  }

  /**
   * โหลดการตั้งค่าทั้งหมด
   */
  async initialize() {
    try {
      // โหลด business config
      const businessResponse = await fetch('/dashbord-admin/data/business-config.json');
      this.businessConfig = await businessResponse.json();

      // โหลด API config
      const apiResponse = await fetch('/dashbord-admin/data/api-config.json');
      this.apiConfig = await apiResponse.json();

      // ตั้งค่า theme จาก business config
      this.themeConfig = this.businessConfig.theme;

      this.initialized = true;
      this.applyThemeSettings();

      console.log('Config Manager initialized successfully');
      return true;
    } catch (error) {
      console.error('Failed to initialize Config Manager:', error);
      return false;
    }
  }

  /**
   * ใช้การตั้งค่า theme
   */
  applyThemeSettings() {
    if (!this.themeConfig) return;

    const root = document.documentElement;
    root.style.setProperty('--primary-color', this.themeConfig.primary_color);
    root.style.setProperty('--secondary-color', this.themeConfig.secondary_color);
    root.style.setProperty('--accent-color', this.themeConfig.accent_color);
    root.style.setProperty('--success-color', this.themeConfig.success_color);
    root.style.setProperty('--warning-color', this.themeConfig.warning_color);
    root.style.setProperty('--danger-color', this.themeConfig.danger_color);
  }

  /**
   * รับข้อมูลบริษัท
   */
  getCompanyInfo() {
    return this.businessConfig?.company || {};
  }

  /**
   * รับการตั้งค่าธุรกิจ
   */
  getBusinessSettings() {
    return this.businessConfig?.settings || {};
  }

  /**
   * รับการตั้งค่า API
   */
  getApiConfig() {
    return this.apiConfig || {};
  }

  /**
   * รับการตั้งค่า theme
   */
  getThemeConfig() {
    return this.themeConfig || {};
  }

  /**
   * รับฟีเจอร์ที่เปิดใช้งาน
   */
  getEnabledFeatures() {
    return this.businessConfig?.features || {};
  }

  /**
   * ตรวจสอบว่าฟีเจอร์เปิดใช้งานหรือไม่
   */
  isFeatureEnabled(featureName) {
    return this.businessConfig?.features?.[featureName] || false;
  }

  /**
   * อัปเดตการตั้งค่า (สำหรับ admin)
   */
  async updateBusinessConfig(newConfig) {
    try {
      // ในโปรดักชั่น จะส่งไปยัง API
      // แต่ตอนนี้เก็บใน localStorage เป็น fallback
      localStorage.setItem('business_config_override', JSON.stringify(newConfig));

      // อัปเดต config ปัจจุบัน
      this.businessConfig = { ...this.businessConfig, ...newConfig };
      this.applyThemeSettings();

      return true;
    } catch (error) {
      console.error('Failed to update business config:', error);
      return false;
    }
  }

  /**
   * รีเซ็ตการตั้งค่าทั้งหมด
   */
  resetToDefaults() {
    localStorage.removeItem('business_config_override');
    // รีโหลดหน้าเพื่อใช้ค่า default
    window.location.reload();
  }
}

// สร้าง instance กลาง
const configManager = new ConfigManager();

// ส่งออกสำหรับการใช้งาน
window.ConfigManager = configManager;
