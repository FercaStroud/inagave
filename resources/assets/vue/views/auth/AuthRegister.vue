<script lang="ts">
import {Component, Vue} from 'vue-property-decorator';
import {Action} from 'vuex-class';

import dialog from '@/utils/dialog';
import formValidation from '@/utils/formValidation';
import checkResponse from '@/utils/checkResponse';

@Component
export default class AuthRegister extends Vue {
  @Action setDialogMessage;

  form = {};
  isSending = false;

  async doRegister() {
    const response = await this.axios.post('register', this.form);

    const checkErrors = checkResponse(response);

    if (checkErrors) {
      this.setDialogMessage(checkErrors.message);
      return;
    }

    this.setDialogMessage('login.account_created');

    await this.$router.push({name: 'auth.login'});
  }

  async register(evt: Event) {
    if (!formValidation(evt)) return;

    this.isSending = true;

    try {
      await this.doRegister();
    } catch {
      this.setDialogMessage('errors.generic_error');
    }

    this.isSending = false;
  }
}
</script>

<template lang="pug">
  b-form(@submit='register')
    b-container(fluid)
      b-row
        b-col(md="12")
          hr
        b-col(md="4" )
          b-form-group.montserrat.text-primary(
            :label='$t("strings.name")'
            label-for='name',
          )
            b-form-input#name(
              type='text',
              v-model='form.name',
              maxlength='25',
              required,
              autofocus,
            )
        b-col(md="4" )
          b-form-group.montserrat.text-primary(
            :label='$t("strings.lastname")'
            label-for='lastname',
          )
            b-form-input#lastname(
              type='text',
              v-model='form.lastname',
              maxlength='15',
              required,
              autofocus,
            )
        b-col(md="4" )
          b-form-group.montserrat.text-primary(
            :label='$t("strings.second_lastname")'
            label-for='second_lastname',
          )
            b-form-input#second_lastname(
              type='text',
              v-model='form.second_lastname',
              maxlength='15',
              autofocus,
            )
        b-col(md="12")
          hr
        b-col(md="12")
          b-form-group.montserrat.text-primary(
            :label='$t("strings.email")'
            label-for='email',
          )
            b-form-input#email(
              type='email',
              v-model='form.email',
              name='email',
              maxlength='191',
              required,
            )
        b-col(md="12")
          hr
        b-col(md="12")
          b-form-group.montserrat.text-primary(
            :label='$t("strings.address")'
            label-for='address',
          )
            b-form-input#address(
              type='text',
              v-model='form.address',
              name='address',
              required,
            )
        b-col(md="6" lg="3" sm="12")
          b-form-group.montserrat.text-primary(
            :label='$t("strings.municipality")'
            label-for='municipality',
          )
            b-form-input#municipality(
              type='text',
              v-model='form.municipality',
              name='state',
              required,
            )
        b-col(md="6" lg="3" sm="12")
          b-form-group.montserrat.text-primary(
            :label='$t("strings.city")'
            label-for='city',
          )
            b-form-input#city(
              type='text',
              v-model='form.city',
              name='state',
              required,
            )
        b-col(md="6" lg="3" sm="12")
          b-form-group.montserrat.text-primary(
            :label='$t("strings.country")'
            label-for='country',
          )
            b-form-input#country(
              type='text',
              v-model='form.country',
              name='state',
              required,
            )
        b-col(md="6" lg="3" sm="12")
          b-form-group.montserrat.text-primary(
            :label='$t("strings.state")'
            label-for='state',
          )
            b-form-input#state(
              type='text',
              v-model='form.state',
              name='state',
              required,
            )
        b-col(md="12")
          hr
        b-col(md="6")
          b-form-group.montserrat.text-primary(
            :label='$t("strings.password")'
            label-for='password',
          )
            b-form-input(
              type='password',
              v-model='form.password',
              name='password',
              required,
            )

        b-col(md="6")
          b-form-group.montserrat.text-primary(
            :label='$t("settings.password_confirmation")'
            label-for='password_confirmation',
          )
            b-form-input(
              type='password',
              v-model='form.password_confirmation',
              name='password_confirmation',
              required,
            )

        b-col(md="12")
          hr
        b-col(md="12")
          b-form-group
            b-button(
              type='submit',
              variant='primary',
              :class='{ disabled: isSending }',
            ) {{ $t('login.register') }}
</template>
<style scoped lang="scss">
</style>
