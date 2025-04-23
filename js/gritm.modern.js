/**
 * Gritm - Modern JavaScript Library
 * A refactored, modular version of the original Gritm library
 */

// Configuration
const CONFIG = {
  reloadAfterSubmit: true,
  debug: true
};

/**
 * Logging utility
 */
const logger = {
  log: (...args) => {
    if (CONFIG.debug) {
      console.log(...args);
    }
  },
  error: (...args) => {
    if (CONFIG.debug) {
      console.error(...args);
    }
  }
};

/**
 * Helper utilities for common operations
 */
const helper = {
  /**
   * Validates an email address
   * @param {string} email - Email address to validate
   * @returns {boolean|string} - true if valid, error message if invalid
   */
  emailCheck(email) {
    // Simple regex for basic validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      return "Please enter a valid email address";
    }
    
    // Domain validation
    const [, domain] = email.split('@');
    const validTLDs = /\.(com|net|org|edu|int|mil|gov|arpa|biz|aero|name|coop|info|pro|museum|[a-z]{2})$/i;
    
    if (!validTLDs.test(domain)) {
      return "The address must end in a valid domain";
    }
    
    return true;
  },

  /**
   * Gets file extension from filename
   * @param {string} filename - Filename to process
   * @returns {string} - The file extension
   */
  getFileExtension(filename) {
    if (!filename) return '';
    return filename.split('.').pop();
  },

  /**
   * Gets basename from file path
   * @param {string} filePath - File path
   * @returns {string} - The basename
   */
  basename(filePath) {
    if (!filePath) return '';
    return filePath.split('/').pop();
  },

  /**
   * Gets directory name from file path
   * @param {string} filePath - File path
   * @returns {string} - The directory name
   */
  dirname(filePath) {
    if (!filePath) return '';
    const parts = filePath.split('/');
    parts.pop();
    return parts.length ? parts.join('/') : '';
  },

  /**
   * Reloads the current page
   */
  reloadPage() {
    window.location.reload();
  },

  /**
   * Gets the length of an object
   * @param {Object} obj - Object to measure
   * @returns {number} - Number of properties
   */
  getObjectLength(obj) {
    if (!obj) return 0;
    return Object.keys(obj).length;
  },

  /**
   * Gets the maximum numeric index in an object
   * @param {Object} obj - Object to check
   * @returns {number} - Maximum index
   */
  getMaxObjectIndex(obj) {
    if (!obj) return 0;
    
    return Math.max(
      0,
      ...Object.keys(obj)
        .map(key => parseInt(key, 10))
        .filter(key => !isNaN(key))
    );
  },

  /**
   * Generates a unique ID
   */
  generateUniqueId: (() => {
    let counter = Math.floor(Math.random() * 10000);
    return () => `gritm-${Date.now()}-${++counter}`;
  })(),

  /**
   * Creates an HTML element with attributes and innerHTML
   * @param {string} tagName - HTML tag name
   * @param {Object} attributes - HTML attributes
   * @param {string} innerHTML - Inner HTML content
   * @returns {HTMLElement} - Created element
   */
  createElement(tagName, attributes = {}, innerHTML = '') {
    const element = document.createElement(tagName);
    
    if (innerHTML) {
      element.innerHTML = innerHTML;
    }
    
    Object.entries(attributes).forEach(([key, value]) => {
      element.setAttribute(key, value);
    });
    
    return element;
  }
};

/**
 * HTTP client for AJAX operations
 */
const http = {
  /**
   * Performs a GET request and returns JSON
   * @param {string} url - URL to fetch
   * @returns {Promise<Object>} - Response data
   */
  async get(url) {
    try {
      const response = await fetch(url);
      
      if (!response.ok) {
        throw new Error(`HTTP error: ${response.status}`);
      }
      
      return await response.json();
    } catch (error) {
      logger.error('HTTP GET error:', error);
      throw error;
    }
  },

  /**
   * Submits form data
   * @param {string} url - URL to submit to
   * @param {FormData} formData - Form data to submit
   * @returns {Promise<Object>} - Response data
   */
  async submitForm(url, formData) {
    try {
      const response = await fetch(url, {
        method: 'POST',
        body: formData
      });
      
      if (!response.ok) {
        throw new Error(`HTTP error: ${response.status}`);
      }
      
      return await response.json();
    } catch (error) {
      logger.error('Form submission error:', error);
      throw error;
    }
  }
};

/**
 * Table-related functionality
 */
const table = {
  /**
   * Gets the selected row for a table
   * @param {string} tableDbName - Database table name
   * @returns {HTMLElement|null} - Selected row or null
   */
  getSelectedRow(tableDbName) {
    const table = document.querySelector(`table[table-db-name="${tableDbName}"]`);
    return table?.querySelector('tr.selected') || null;
  }
};

/**
 * Modal/Popup functionality
 */
const popup = (() => {
  // Private state
  let modalCounter = 1;
  
  // Default configuration for popups
  const defaultConfig = {
    title: 'Gritm app window',
    html: '',
    onload: () => logger.log('Popup loaded'),
    buttons: [{
      caption: 'Ok',
      attributes: { class: 'btn' },
      click: (popupElement) => $(popupElement).modal('hide')
    }],
    closeButton: true,
    width: 400,
    height: 200
  };

  /**
   * Creates a popup element
   * @param {Object} config - Popup configuration
   * @returns {JQuery} - jQuery modal element
   */
  const createPopup = (config) => {
    const id = `modal-${++modalCounter}`;
    const mergedConfig = { ...defaultConfig, ...config };
    
    // Create modal container
    const modalWindow = helper.createElement('div', {
      id,
      class: 'modal hide fade in'
    });
    
    // Create header
    const modalHeader = helper.createElement('div', { class: 'modal-header' });
    
    if (mergedConfig.closeButton) {
      const closeButton = helper.createElement('button', {
        type: 'button',
        class: 'close',
        'data-dismiss': 'modal',
        'aria-hidden': true
      }, '&times;');
      
      modalHeader.appendChild(closeButton);
    }
    
    modalHeader.appendChild(helper.createElement('h3', {}, mergedConfig.title));
    modalWindow.appendChild(modalHeader);
    
    // Create body
    modalWindow.appendChild(helper.createElement('div', {
      class: 'modal-body'
    }, mergedConfig.html));
    
    // Create footer
    const modalFooter = helper.createElement('div', { class: 'modal-footer' });
    
    if (mergedConfig.closeButton) {
      modalFooter.appendChild(helper.createElement('button', {
        class: 'btn',
        'data-dismiss': 'modal'
      }, 'Close'));
    }
    
    // Add custom buttons
    if (mergedConfig.buttons) {
      mergedConfig.buttons.forEach(buttonConfig => {
        const attributes = {
          class: 'btn',
          ...buttonConfig.attributes
        };
        
        const button = helper.createElement('button', attributes, buttonConfig.caption);
        button.addEventListener('click', () => buttonConfig.click(modalWindow));
        modalFooter.appendChild(button);
      });
    }
    
    modalWindow.appendChild(modalFooter);
    
    // Add to document
    const body = document.querySelector('body');
    if (body.firstChild) {
      body.insertBefore(modalWindow, body.firstChild);
    } else {
      body.appendChild(modalWindow);
    }
    
    return $(`#${id}`);
  };

  /**
   * Handles popup load events
   * @param {Object} response - Server response data
   */
  const handlePopupLoad = (response) => {
    // Handle JavaScript code (safely)
    if (response.javascript) {
      try {
        // Use Function constructor instead of eval for better scoping
        const execFn = new Function(response.javascript);
        execFn();
      } catch (error) {
        logger.error('Error executing dynamic JavaScript:', error);
      }
    }
    
    // Add CSS styles
    if (response.css) {
      const styleElement = helper.createElement('style', { type: 'text/css' }, response.css);
      document.head.appendChild(styleElement);
    }
  };

  /**
   * Creates form fields from response data
   * @param {Object} response - Server response data
   * @returns {HTMLElement} - Form definition list with fields
   */
  const createFormFields = (response) => {
    const definitionList = document.createElement('dl');
    
    if (response.fields) {
      Object.entries(response.fields).forEach(([, field]) => {
        if (!field.html) return;
        
        const dt = helper.createElement('dt', {}, field.name);
        const dd = helper.createElement('dd', {}, field.html);
        
        definitionList.appendChild(dt);
        definitionList.appendChild(dd);
      });
    }
    
    return definitionList;
  };

  /**
   * Handles form submission
   * @param {HTMLElement} form - Form element to submit
   * @returns {Promise<void>}
   */
  const submitForm = async (form) => {
    try {
      const formData = new FormData(form);
      await http.submitForm(form.action, formData);
      
      if (CONFIG.reloadAfterSubmit) {
        helper.reloadPage();
      }
    } catch (error) {
      alert(`Error submitting form: ${error.message}`);
    }
  };

  // Public API
  return {
    /**
     * Shows a popup
     * @param {Object} config - Popup configuration
     */
    show(config) {
      const modalElement = createPopup(config);
      
      if (typeof config.onload === 'function') {
        modalElement.on('show', config.onload);
      }
      
      modalElement.modal('show');
    },
    
    /**
     * Shows an error popup
     * @param {string} message - Error message
     */
    showError(message) {
      this.show({
        title: 'Error',
        html: message
      });
    },
    
    /**
     * Shows a popup for adding a new record
     * @param {string} tableDbName - Database table name
     */
    async showAddNewRecord(tableDbName) {
      try {
        const response = await http.get(`?table=${tableDbName}&mode=new`);
        
        if (!response || response.error || response.result !== 'ok') {
          throw new Error(response?.error || 'Failed to get fields');
        }
        
        const form = helper.createElement('form', {
          action: `?table=${tableDbName}&mode=new`,
          method: 'post',
          enctype: 'multipart/form-data'
        });
        
        form.appendChild(createFormFields(response));
        
        this.show({
          title: 'Add new record',
          html: form.outerHTML,
          onload: () => handlePopupLoad(response),
          buttons: [{
            caption: 'Add',
            attributes: { class: 'btn btn-primary' },
            click: (popupElement) => {
              const formElement = popupElement.querySelector('form');
              submitForm(formElement);
            }
          }]
        });
      } catch (error) {
        this.showError(`Error getting fields for adding new record: ${error.message}`);
      }
    },
    
    /**
     * Shows a popup for editing a record
     * @param {string} tableDbName - Database table name
     * @param {string|number} pkValue - Primary key value
     */
    async showEditRecord(tableDbName, pkValue) {
      if (!pkValue) {
        return this.showError('Please select a row to update');
      }
      
      try {
        const response = await http.get(`?table=${tableDbName}&mode=edit&pk=${pkValue}`);
        
        if (!response || response.error || response.result !== 'ok') {
          throw new Error(response?.error || 'Failed to get fields');
        }
        
        const form = helper.createElement('form', {
          action: `?table=${tableDbName}&mode=edit&pk=${pkValue}`,
          method: 'post',
          enctype: 'multipart/form-data'
        });
        
        form.appendChild(createFormFields(response));
        
        this.show({
          title: 'Update record',
          html: form.outerHTML,
          onload: () => handlePopupLoad(response),
          buttons: [{
            caption: 'Update',
            attributes: { class: 'btn btn-primary' },
            click: (popupElement) => {
              const formElement = popupElement.querySelector('form');
              submitForm(formElement);
            }
          }]
        });
      } catch (error) {
        this.showError(`Error getting fields for editing record: ${error.message}`);
      }
    },
    
    /**
     * Shows a popup for deleting a record
     * @param {string} tableDbName - Database table name
     * @param {string|number} pkValue - Primary key value
     */
    showDeleteRecord(tableDbName, pkValue) {
      if (!pkValue) {
        return this.showError('Please select a row to delete');
      }
      
      this.show({
        title: 'Delete a record',
        html: 'Are you sure you want to delete this record?',
        buttons: [{
          caption: 'Delete',
          attributes: { class: 'btn btn-danger' },
          click: async () => {
            try {
              const formData = new FormData();
              await http.submitForm(`?table=${tableDbName}&mode=delete&pk=${pkValue}`, formData);
              
              if (CONFIG.reloadAfterSubmit) {
                helper.reloadPage();
              }
            } catch (error) {
              this.showError(`Error deleting record: ${error.message}`);
            }
          }
        }]
      });
    }
  };
})();

// Export Gritm namespace to global scope
window.Gritm = {
  CONFIG,
  helper,
  table,
  popup
};

// Also export as ES module for modern usage
export default {
  CONFIG,
  helper,
  table,
  popup
};
