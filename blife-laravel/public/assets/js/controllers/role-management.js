class RoleManagement {
  constructor() {
    this.roles = [];
    this.permissions = {};
    this.currentUserRole = null;
    this.init();
  }

  async init() {
    await this.loadRoles();
    await this.loadPermissions();
    this.setupEventListeners();
  }

  async loadRoles() {
    try {
      this.roles = await apiService.getRoles();
    } catch (error) {
      console.error('Failed to load roles:', error);
      // Fallback to mockup roles
      this.roles = [
        { id: 1, name: 'ผู้ดูแลระบบ', permissions: ['all'] },
        { id: 2, name: 'ผู้ขาย', permissions: ['products', 'orders', 'categories'] },
        { id: 3, name: 'ลูกค้า', permissions: ['profile', 'orders'] }
      ];
    }
  }

  async loadPermissions() {
    try {
      this.permissions = await apiService.getPermissions();
    } catch (error) {
      console.error('Failed to load permissions:', error);
      // Fallback to default permissions
      this.permissions = {
        products: ['index', 'create', 'edit', 'destroy'],
        categories: ['index', 'create', 'edit', 'destroy'],
        attributes: ['index', 'create', 'edit', 'destroy'],
        users: ['index', 'create', 'edit', 'destroy'],
        orders: ['index', 'create', 'edit', 'destroy'],
        localization: ['index', 'create', 'edit', 'destroy'],
        coupons: ['index', 'create', 'edit', 'destroy'],
        tax: ['index', 'create', 'edit', 'destroy'],
        reviews: ['index', 'create', 'edit', 'destroy'],
        tickets: ['index', 'create', 'edit', 'destroy'],
        reports: ['index']
      };
    }
  }

  setupEventListeners() {
    // Role creation form
    const roleForm = document.getElementById('create-role-form');
    if (roleForm) {
      roleForm.addEventListener('submit', (e) => this.handleRoleSubmit(e));
    }

    // Permission checkboxes
    this.setupPermissionCheckboxes();
  }

  setupPermissionCheckboxes() {
    // Handle "All" checkboxes
    const allCheckboxes = document.querySelectorAll('.checkall');
    allCheckboxes.forEach(checkbox => {
      checkbox.addEventListener('change', (e) => {
        const groupClass = e.target.classList.contains('checkall') ? 'check-it' :
                          e.target.classList.contains('checkall1') ? 'check-it1' :
                          e.target.classList.contains('checkall2') ? 'check-it2' :
                          e.target.classList.contains('checkall3') ? 'check-it3' :
                          e.target.classList.contains('checkall4') ? 'check-it4' :
                          e.target.classList.contains('checkall5') ? 'check-it5' :
                          e.target.classList.contains('checkall6') ? 'check-it6' :
                          e.target.classList.contains('checkall7') ? 'check-it7' :
                          e.target.classList.contains('checkall8') ? 'check-it8' :
                          e.target.classList.contains('checkall9') ? 'check-it9' :
                          e.target.classList.contains('checkall10') ? 'check-it10' :
                          e.target.classList.contains('checkall11') ? 'check-it11' : 'check-it';

        const groupCheckboxes = document.querySelectorAll(`.${groupClass}`);
        groupCheckboxes.forEach(cb => {
          cb.checked = e.target.checked;
        });
      });
    });
  }

  async handleRoleSubmit(e) {
    e.preventDefault();

    const formData = new FormData(e.target);
    const roleName = formData.get('role-name');

    if (!roleName) {
      this.showNotification('กรุณากรอกชื่อบทบาท', 'error');
      return;
    }

    const permissions = this.collectPermissions();

    const roleData = {
      name: roleName,
      permissions: permissions,
      created_at: new Date().toISOString()
    };

    try {
      const newRole = await apiService.createRole(roleData);
      this.roles.push(newRole);
      this.showNotification('สร้างบทบาทสำเร็จ', 'success');
      this.resetForm();
      this.refreshRoleList();
    } catch (error) {
      console.error('Failed to create role:', error);
      this.showNotification('เกิดข้อผิดพลาดในการสร้างบทบาท', 'error');
    }
  }

  collectPermissions() {
    const permissions = {};

    // Collect permissions from checkboxes
    const permissionGroups = [
      'roles', 'users', 'products', 'categories', 'attributes', 'orders',
      'localization', 'coupons', 'tax', 'reviews', 'tickets', 'reports'
    ];

    permissionGroups.forEach(group => {
      const allCheckbox = document.querySelector(`input[id*="${group}"][class*="checkall"]`);
      if (allCheckbox && allCheckbox.checked) {
        permissions[group] = ['all'];
      } else {
        const groupPermissions = [];
        const checkboxes = document.querySelectorAll(`input[class*="check-it"][id*="${group}"]`);
        checkboxes.forEach(cb => {
          if (cb.checked) {
            const action = cb.id.includes('index') ? 'index' :
                          cb.id.includes('create') ? 'create' :
                          cb.id.includes('edit') ? 'edit' :
                          cb.id.includes('destroy') ? 'destroy' : '';
            if (action && !groupPermissions.includes(action)) {
              groupPermissions.push(action);
            }
          }
        });
        if (groupPermissions.length > 0) {
          permissions[group] = groupPermissions;
        }
      }
    });

    return permissions;
  }

  resetForm() {
    const form = document.getElementById('create-role-form');
    if (form) {
      form.reset();
    }

    // Reset all checkboxes
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = false);
  }

  async refreshRoleList() {
    try {
      this.roles = await apiService.getRoles();
      this.renderRoleList();
    } catch (error) {
      console.error('Failed to refresh role list:', error);
    }
  }

  renderRoleList() {
    const roleTable = document.querySelector('#table_id tbody');
    if (!roleTable) return;

    roleTable.innerHTML = '';

    this.roles.forEach(role => {
      const row = document.createElement('tr');
      row.innerHTML = `
        <td>${role.id}</td>
        <td>${role.name}</td>
        <td>${role.created_at || '3 weeks ago'}</td>
        <td>
          <ul>
            <li><a href="javascript:void(0)" onclick="roleManagement.editRole(${role.id})"><i class="ri-pencil-line"></i></a></li>
            <li><a href="javascript:void(0)" onclick="roleManagement.deleteRole(${role.id})" data-bs-toggle="modal" data-bs-target="#exampleModalToggle"><i class="ri-delete-bin-line"></i></a></li>
          </ul>
        </td>
      `;
      roleTable.appendChild(row);
    });
  }

  async editRole(roleId) {
    const role = this.roles.find(r => r.id === roleId);
    if (!role) return;

    // Populate form with role data
    const nameInput = document.querySelector('input[name="role-name"]');
    if (nameInput) {
      nameInput.value = role.name;
    }

    // Populate permissions
    this.populatePermissions(role.permissions);

    // Change form to edit mode
    const form = document.getElementById('create-role-form');
    if (form) {
      form.setAttribute('data-edit-id', roleId);
      const submitBtn = form.querySelector('button[type="submit"]');
      if (submitBtn) {
        submitBtn.textContent = 'อัปเดตบทบาท';
      }
    }
  }

  populatePermissions(permissions) {
    // Reset all checkboxes first
    const checkboxes = document.querySelectorAll('input[type="checkbox"]');
    checkboxes.forEach(cb => cb.checked = false);

    // Set permissions
    Object.entries(permissions).forEach(([group, actions]) => {
      if (actions.includes('all')) {
        const allCheckbox = document.querySelector(`input[class*="checkall"][id*="${group}"]`);
        if (allCheckbox) allCheckbox.checked = true;
      } else {
        actions.forEach(action => {
          const checkbox = document.querySelector(`input[class*="check-it"][id*="${group}"][id*="${action}"]`);
          if (checkbox) checkbox.checked = true;
        });
      }
    });
  }

  async deleteRole(roleId) {
    if (!confirm('คุณแน่ใจหรือไม่ว่าต้องการลบบทบาทนี้?')) return;

    try {
      await apiService.deleteRole(roleId);
      this.roles = this.roles.filter(r => r.id !== roleId);
      this.showNotification('ลบบทบาทสำเร็จ', 'success');
      this.refreshRoleList();
    } catch (error) {
      console.error('Failed to delete role:', error);
      this.showNotification('เกิดข้อผิดพลาดในการลบบทบาท', 'error');
    }
  }

  hasPermission(resource, action) {
    if (!this.currentUserRole) return false;

    const rolePermissions = this.currentUserRole.permissions;
    if (!rolePermissions) return false;

    // Check if user has 'all' permission for the resource
    if (rolePermissions[resource]?.includes('all')) return true;

    // Check specific action permission
    return rolePermissions[resource]?.includes(action) || false;
  }

  setCurrentUserRole(role) {
    this.currentUserRole = role;
  }

  showNotification(message, type = 'info') {
    // Use existing notification system or create a simple alert
    if (typeof $.notify !== 'undefined') {
      $.notify(message, type);
    } else {
      alert(message);
    }
  }
}

// Create global instance
const roleManagement = new RoleManagement();
