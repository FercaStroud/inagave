<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import { Action } from 'vuex-class';

import dialog from '@/utils/dialog';
import formValidation from '@/utils/formValidation';

import checkResponse from '@/utils/checkResponse';

@Component
export default class AuthResetForm extends Vue {
  @Action setDialogMessage;

  form = {
    token: '',
  };
  isSending = false;
  validToken = false;

  async mounted() {
    this.form.token = this.$route.params.token;
  }

  async doSubmit() {
    const response = await this.axios.post('app/password/reset/token', this.form);

    const checkErrors = checkResponse(response);

    if (checkErrors) {
      this.setDialogMessage(checkErrors.message);
      return;
    }

    this.setDialogMessage('passwords.reset');

    await this.$router.push({name: 'auth.login'});
  }

  async submitForm(evt: Event) {
    if (!formValidation(evt)) return;

    this.isSending = true;

    try {
      await this.doSubmit();
    } catch {
      this.setDialogMessage('errors.generic_error');
    }

    this.isSending = false;
  }
}
</script>

<template lang="pug">
b-container(fluid)
  b-row
    b-col.mt-5.mb-5.shadow(
      md="4"
      sm="10"
      lg="4"
      offset-sm="1"
      style="background-color:rgba(255,255,255,1)"
    )
      router-link(:to='{ name: "auth.login" }')
        img.mt-3(
          src='/assets/images/logo.svg',
          alt='Logo'
          style="width:300px;margin-left:50%;left:-150px;position:relative;"
        )
      b-form(@submit='submitForm')
        h5.title {{ $t('login.reset_password') }}

        b-form-group(
          label='Token'
          label-for='token',
        )
          b-form-input(
            type='text',
            v-model='form.token',
            name='token',
            maxlength='191',
            required,
            autofocus,
            readonly
          )
        b-form-group(
          :label='$t("strings.password")'
          label-for='password',
        )
          b-form-input(
            type='password',
            v-model='form.password',
            required,
          )

        b-form-group
          b-button(
            type='submit',
            variant='primary',
            :class='{ disabled: isSending }',
          ) {{ $t('login.reset_password') }}
</template>
