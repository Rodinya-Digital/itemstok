<template>
  <div class="row" v-if="$parent.userCan('manage-users')">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4>用户 <span v-if="total">({{ total }})</span></h4>
          <div class="card-header-action">
            <a v-if="$parent.userCan('create-users')" v-bind:href="$parent.MakeUrl('panel/users/create')"
               class="btn btn-primary">添加用户 <i class="fas fa-plus"></i></a>
          </div>
        </div>
        <div class="card-body p-0">
          <div class="table-responsive table-invoice" v-if="!loading">
            <table class="table table-striped" v-if="users.length">
              <tbody>
              <tr>
                <th>名</th>
                <th>姓</th>
                <th>邮箱</th>
                <th>状态</th>
                <th>注册日期</th>
                <th></th>
              </tr>
              <tr v-for="user, index in users">
                <td>{{ user.name }}</td>
                <td>{{ user.surname }}</td>
                <td>{{ user.email }}</td>
                <td><div v-if="user.status==1" class="badge badge-success">可用</div><div v-if="user.status==0" class="badge badge-danger">不可用</div></td>
                <td>{{ user.created_at }}</td>
                <td class="text-right">
                  <a v-if="$parent.userCan('edit-users')" v-bind:href="'/panel/uservice/user/'+user.id" class="btn btn-warning">
                    <i class="fa fa-user-cog"></i>
                  </a>
                  <button v-if="$parent.userCan('delete-users') && !user.isme" @click="deleteUser(user.id, index)"
                          class="btn btn-danger">
                    <i class="fa fa-trash"></i>
                  </button>
                  <a v-if="$parent.userCan('edit-users')" v-bind:href="user.profilelink" class="btn btn-primary">
                    <i class="fa fa-user-edit"></i>
                  </a>
                </td>
              </tr>
              </tbody>
            </table>
            <div v-if="!users.length" class="text-center p-3 text-muted">
              <h5>没有结果</h5>
              <p>您似乎还没有添加任何用户！</p>
            </div>
          </div>
          <div class="text-center p-4 text-muted" v-else>
            <h5>加载中</h5>
            <p>正在加载数据...请稍候。</p>
          </div>
        </div>
      </div>
      <div class="text-center" v-if="users.length && total > users.length">
        <button v-bind:disabled="loading" @click="loadUsers" class="btn btn-primary"><span v-if="loading">加载中 <i
            class="fas fa-spinner fa-spin"></i></span><span v-else>加载更多</span></button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      users: [],
      total: 0,
      loading: false,
      loadingmore: false,
      query: '',
      url: ''
    }
  },
  mounted() {
    let query = location.search.split('query=')[1];
    if (query !== undefined) {
      this.query = query;
    }
    this.url = BaseUrl('panel/users?q=' + this.query);
    this.loadUsers();
  },
  methods: {
    loadUsers() {
      let _this = this;
      _this.loading = true;
      axios.get(_this.url).then((res) => {
        _this.users = _this.users.concat(res.data.data);
        _this.total = res.data.total;
        _this.loading = false;
        _this.url = res.data.next_page_url;
      }).catch((err) => {
        _this.loading = false;
      });
    },
    deleteUser(userId, index) {
      let _this = this;
      this.$iosConfirm({
        title: '你确定吗？',
        text: '所选用户将从系统中永久删除。',
        cancelText: '取消',
        okText: '确定删除！'
      }).then(function () {
        axios.delete(_this.$parent.MakeUrl('panel/users/' + userId)).then((res) => {
          _this.users.splice(index, 1);
          _this.total = _this.total - 1;
          _this.loadUsers();
        }).catch(error => {
          _this.$iosAlert({
            'title': '错误',
            'text': error.response.data.message
          });
        });
      });
    }
  }
}
</script>
