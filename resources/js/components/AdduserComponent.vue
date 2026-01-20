<template>
  <div class="row">
    <div class="col-12">
      <div class="alert alert-primary" v-if="message">
        {{ message }}
      </div>
      <div class="card">
        <div class="card-header">
          <h4>注册账号</h4>
        </div>
        <div class="card-body">
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">名</label>
            <div class="col-sm-12 col-md-7">
              <input v-bind:class="{'is-invalid': errors.name}" type="text" v-model="name" class="form-control" placeholder="名">
              <div class="invalid-feedback" v-if="errors.name">
                <p>{{ errors.name[0] }}</p>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">姓</label>
            <div class="col-sm-12 col-md-7">
              <input v-bind:class="{'is-invalid': errors.surname}" type="text" v-model="surname" class="form-control" placeholder="姓">
              <div class="invalid-feedback" v-if="errors.surname">
                <p>{{ errors.surname[0] }}</p>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">邮箱</label>
            <div class="col-sm-12 col-md-7">
              <input v-bind:class="{'is-invalid': errors.email}" type="text" v-model="email" class="form-control" placeholder="邮箱">
              <div class="invalid-feedback" v-if="errors.email">
                <p>{{ errors.email[0] }}</p>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">用户类型</label>
            <div class="col-sm-12 col-md-7">
              <select class="form-control" v-model="role" v-bind:class="{'is-invalid': errors.role}">
                <option value="">选择</option>
                <option v-for="role in roles" v-bind:value="role.id">{{ role.name }}</option>
              </select>
              <div class="invalid-feedback" v-if="errors.role">
                <p>{{ errors.role[0] }}</p>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">密码</label>
            <div class="col-sm-12 col-md-7">
              <input v-bind:class="{'is-invalid': errors.password}" type="password" v-model="password" class="form-control" autocomplete="new-password" placeholder="密码">
              <div class="invalid-feedback" v-if="errors.password">
                <p>{{ errors.password[0] }}</p>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3">重复密码</label>
            <div class="col-sm-12 col-md-7">
              <input v-bind:class="{'is-invalid': errors.password_confirmation}" type="password" v-model="password_confirmation" class="form-control" placeholder="重复密码" autocomplete="new-password">
              <div class="invalid-feedback" v-if="errors.password_confirmation">
                <p>{{ errors.password_confirmation[0] }}</p>
              </div>
            </div>
          </div>
          <div class="form-group row mb-4">
            <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
            <div class="col-sm-12 col-md-7">
              <button v-bind:disabled="loading" @click="addUser" class="btn btn-primary"><span v-if="loading">注册中</span><span v-else>添加</span></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      name: '',
      surname: '',
      email: '',
      password: '',
      password_confirmation: '',
      errors: [],
      role: '',
      roles: '',
      message: '',
      loading: false
    }
  },
  mounted() {
    this.getRoles();
  },
  methods: {
    getRoles() {
      axios.get(this.$parent.MakeUrl('panel/users/roles')).then((res) => {
        this.roles = res.data;
      }).catch((err) => {

      });
    },
    addUser() {
      let _this = this;
      _this.errors = [];
      _this.message = '';
      _this.loading = true;
      axios.post(this.$parent.MakeUrl('panel/users'), {'name': this.name, 'surname': this.surname, 'role': this.role, 'email': this.email, 'current_password': this.current_password, 'password': this.password, 'password_confirmation': this.password_confirmation}).then((res) => {
        _this.loading = false;
        _this.resetForm();
        _this.message = '成功的！';
      }).catch((err) => {
        _this.errors = err.response.data.errors;
        _this.loading = false;
      });
    },
    resetForm() {
      this.name = '';
      this.surname = '';
      this.email = '';
      this.password = '';
      this.role = '';
      this.password_confirmation = '';
    }
  }
}
</script>
