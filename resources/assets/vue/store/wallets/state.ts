export default {
  fields: [
    {
      key: 'id',
      label: 'ID',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'index',
      label: '#',
      class: 'text-center',
    },
    {
      key: 'user_name',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'status',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'amount',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'bank',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'account',
      class: 'text-right',
      sortable: true,
    },
    {
      key: 'type',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'details',
      class: 'text-center',
    },
    {
      key: 'created_at',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'actions',
      class: 'text-center',
    },
  ],
  wallets: [],
  form:{},
  isLoading: false,
  isModalAdd: false,
  isModalVisible: false,
};
