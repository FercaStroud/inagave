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
      key: 'maintenance',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'created_at',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'updated_at',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'actions',
      class: 'text-center',
    },
  ],
  settings: {},
  form:{},
  isLoading: false,
  isModalLoading: false,
  isModalAdd: false,
  isModalVisible: false,
};
