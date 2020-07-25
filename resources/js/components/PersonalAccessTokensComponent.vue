<template>
    <div>
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Personal Access Tokens</h3>
                <div class="card-tools">
                    <a href="javascript:void(0);" class="btn btn-primary btn-sm elevation-1"
                        @click="showCreateTokenForm">
                        Create New Token
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <div class="box-body p-2" v-if="0 === tokens.length">
                    <div class="alert alert-info alert-dismissible alert-module">
                        <i class="icon fa fa-info-circle"></i> You have not created any
                        personal access tokens.
                    </div>
                </div>
                <table class="table table-hover" v-if="0 < tokens.length">
                    <thead>
                    <tr>
                        <th class="text-center w-70">Name</th>
                        <th class="text-center w-30">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                        <tr v-for="token in tokens" :key="token.id">
                            <td class="align-middle text-center">{{ token.name }}</td>
                            <td class="align-middle text-center">
                                <a href="javascript:void(0);" class="btn btn-danger btn-sm"
                                    @click="revoke(token)">Delete</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="modal fade show" id="modal-create-token" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Create Token</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger alert-dismissible alert-module"
                            v-if="form.errors.length > 0">
                            <p class="mb-0"><strong><i class="icon fas fa-exclamation-triangle"></i>
                                Whoops!</strong> Something went wrong!
                            </p>
                            <ul class="mb-0">
                                <li v-for="error in form.errors" :key="error.id">{{ error }}</li>
                            </ul>
                        </div>
                        <form role="form" @submit.prevent="store">
                            <div class="form-group row">
                                <label class="col-md-4 col-form-label">Name</label>
                                <div class="col-md-6">
                                    <input id="create-token-name" type="text" class="form-control"
                                        name="name" v-model="form.name">
                                </div>
                            </div>
                            <div class="form-group row" v-if="scopes.length > 0">
                                <label class="col-md-4 col-form-label">Scopes</label>
                                <div class="col-md-6">
                                    <div v-for="scope in scopes" :key="scope.id">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox"
                                                    @click="toggleScope(scope.id)"
                                                    :checked="scopeIsAssigned(scope.id)"
                                                >
                                                    {{ scope.id }}
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-primary" @click="store">
                            Create
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Access Token Modal -->
        <div class="modal fade" id="modal-access-token" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Personal Access Token
                        </h4>

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            &times;
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>
                            Here is your new personal access token. This is the only time it will be
                            shown so don't lose it! You may now use this token to make API requests.
                        </p>

                        <textarea class="form-control" rows="10" :value="accessToken"></textarea>
                    </div>

                    <!-- Modal Actions -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import {
  flatten, reject, toArray, isObject, includes,
} from 'lodash';

export default {
  /*
   * The component's data.
   */
  data() {
    return {
      accessToken: null,

      tokens: [],
      scopes: [],

      form: {
        name: '',
        scopes: [],
        errors: [],
      },
    };
  },
  mounted() {
    this.getTokens();
    this.getScopes();

    $('#modal-create-token').on('shown.bs.modal', () => {
      $('#create-token-name').trigger('focus');
    });
  },

  methods: {
    /**
             * Get all of the personal access tokens for the user.
             */
    getTokens() {
      axios.get('/oauth/personal-access-tokens')
        .then((response) => {
          this.tokens = response.data;
        });
    },

    /**
             * Get all of the available scopes.
             */
    getScopes() {
      axios.get('/oauth/scopes')
        .then((response) => {
          this.scopes = response.data;
        });
    },

    /**
             * Show the form for creating new tokens.
             */
    showCreateTokenForm() {
      $('#modal-create-token').modal('show');
    },

    /**
             * Create a new personal access token.
             */
    store() {
      this.accessToken = null;

      this.form.errors = [];

      axios.post('/oauth/personal-access-tokens', this.form)
        .then((response) => {
          this.form.name = '';
          this.form.scopes = [];
          this.form.errors = [];

          this.tokens.push(response.data.token);

          this.showAccessToken(response.data.accessToken);
        })
        .catch((error) => {
          if (isObject(error.response.data)) {
            this.form.errors = flatten(toArray(error.response.data.errors));
          } else {
            this.form.errors = ['Something went wrong. Please try again.'];
          }
        });
    },

    /**
    * Toggle the given scope in the list of assigned scopes.
    */
    toggleScope(scope) {
      if (this.scopeIsAssigned(scope)) {
        this.form.scopes = reject(this.form.scopes, (s) => s === scope);
      } else {
        this.form.scopes.push(scope);
      }
    },

    /**
    * Determine if the given scope has been assigned to the token.
    */
    scopeIsAssigned(scope) {
      return includes(this.form.scopes, scope);
    },

    /**
             * Show the given access token to the user.
             */
    showAccessToken(accessToken) {
      $('#modal-create-token').modal('hide');

      this.accessToken = accessToken;

      $('#modal-access-token').modal('show');
    },

    /**
             * Revoke the given token.
             */
    revoke(token) {
      axios.delete(`/oauth/personal-access-tokens/${token.id}`)
        .then(() => this.getTokens());
    },
  },
};
</script>
