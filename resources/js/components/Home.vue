<template>
  <div>
    <div class="display-height uk-flex-center uk-flex-middle uk-flex uk-flex-column">
      <div>
        <div class="uk-card uk-card-default uk-card-body">
          <h3 class="uk-card-title">Please enter Promocode and email</h3>
          <form v-if="!loading" @submit.prevent="send">
            <fieldset class="uk-fieldset">

              <div class="uk-margin">
                <input v-model="request.email" class="uk-input" type="email" placeholder="Email">
              </div>

              <div class="uk-margin">
                <input v-model="request.code" class="uk-input"
                       pattern="[A-Z0-9]{12}"
                       type="text"
                       placeholder="Promo Code">
              </div>

              <div class="uk-margin">
                <button type="submit" class="uk-button uk-button-primary uk-align-right">Submit</button>
              </div>
            </fieldset>
          </form>
         <div>
           <div v-if="loading" class="spinner">
             <div class="cube1"></div>
             <div class="cube2"></div>
           </div>
         </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from 'axios'
  import { notification } from 'uikit'

  export default {
    name: 'Home',
    data () {
      return {
        request: {
          code: '123456789ABC',
          email: 'someMail@email.com'
        },
        loading: false
      }
    },
    methods: {
      send () {
        this.loading = true;
        axios.post('api/promocode', this.request)
          .then(response => {
            this.loading = false;
            notification({message: response.data, status: 'success'})
          })
          .catch(e => {
            this.loading = false;
            if (e.response.status === 403) {
              return notification({message: e.response.data, status: 'danger'})
            }
            notification({message: 'an error occurred, please contact to service owners', status: 'danger'})
          })
      }
    }
  }
</script>

<style scoped>

</style>