class TranslationService {
  constructor() {
    this.translations = {};
    this.currentLanguage = 'th'; // Default to Thai
    this.loadTranslations();
  }

  async loadTranslations() {
    try {
      const response = await fetch('data/translations.json');
      this.translations = await response.json();
    } catch (error) {
      console.error('Failed to load translations:', error);
      this.translations = {};
    }
  }

  setLanguage(language) {
    this.currentLanguage = language;
  }

  getLanguage() {
    return this.currentLanguage;
  }

  translate(key, defaultValue = '') {
    const keys = key.split('.');
    let value = this.translations;

    for (const k of keys) {
      if (value && typeof value === 'object' && k in value) {
        value = value[k];
      } else {
        return defaultValue || key;
      }
    }

    return typeof value === 'string' ? value : defaultValue || key;
  }

  // Helper method to translate entire objects
  translateObject(obj) {
    const translated = {};

    for (const [key, value] of Object.entries(obj)) {
      if (typeof value === 'string') {
        translated[key] = this.translate(value, value);
      } else if (typeof value === 'object' && value !== null) {
        translated[key] = this.translateObject(value);
      } else {
        translated[key] = value;
      }
    }

    return translated;
  }

  // Method to update DOM elements with translations
  async translatePage() {
    await this.loadTranslations();

    // Translate elements with data-translate attribute
    const elements = document.querySelectorAll('[data-translate]');
    elements.forEach(element => {
      const key = element.getAttribute('data-translate');
      const translation = this.translate(key);
      if (translation !== key) {
        if (element.tagName === 'INPUT' && element.hasAttribute('placeholder')) {
          element.setAttribute('placeholder', translation);
        } else {
          element.textContent = translation;
        }
      }
    });

    // Translate title
    const titleKey = document.body.getAttribute('data-page-title');
    if (titleKey) {
      document.title = this.translate(titleKey, document.title);
    }
  }

  // Method to get translated text for specific page sections
  getPageTranslations(pageName) {
    return this.translations.pages?.[pageName] || {};
  }

  // Method to get common translations
  getCommonTranslations() {
    return this.translations.common || {};
  }
}

// Create global instance
const translationService = new TranslationService();

// Auto-translate page when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
  translationService.translatePage();
});
