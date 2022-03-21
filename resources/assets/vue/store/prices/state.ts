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
      key: 'price',
      class: 'text-right',
      sortable: true,
    },
    {
      key: 'weight',
      class: 'text-center',
      sortable: true,
    },
    {
      key: 'year',
      class: 'text-right',
      sortable: true,
    },
    {
      key: 'default',
      class: 'text-right',
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
  prices: [],
  pricesArray: [],
  yearsArray: [],
  form:{},
  isLoading: false,
  isModalLoading: false,
  isModalAdd: false,
  isModalVisible: false,
};
