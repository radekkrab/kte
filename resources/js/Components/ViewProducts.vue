<script setup>

    import { ref } from 'vue';
    import { onMounted } from 'vue'
    import { reactive } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import { Link } from '@inertiajs/vue3'
    import { useForm } from '@inertiajs/vue3';
    import EditProduct from './EditProduct.vue';

  

    const props = defineProps({showOpenProductModal: Boolean, equipment: Object});

    const showOpenProductModal = ref(false);
 
  
    let view = null;

    const openProductModal = (props) => {
      props.equipment = props;
      showOpenProductModal.value = true;
    }

    const closeProductModal = () => {
    showOpenProductModal.value = false;
    emit('sendshowOPM', showOPM);
    }
 
    const emit = defineEmits(['sendshowOPM']);

    const showOPM = true;

    function destroy(id) {
            console.log(id);
            axios.post(`/api/equipment/${id}`, {_method: 'delete'})
                .then(res => {
                    console.log(res.data);
                    closeProductModal()
                })
            .catch( e => {
                console.log(e);
                
            })
        }
       
</script>

<template>
     <tr class="border-b-2 border-gray-300 bg-white text-sm lg:text-lg hover:cursor-pointer" @click="openProductModal(props.equipment)">
        <td class="py-2 px-2 lg:py-8 lg:pl-8">{{ props.equipment.id }}</td>
        <td>{{ props.equipment.equipment_type.name  }}</td>
        <td>{{ props.equipment.sn }}</td>
        <td>{{ props.equipment.comment }}</td>
     </tr>
     <Modal :show="showOpenProductModal" @close="closeProductModal">
      <div class="px-3 lg:py-5 h-96 bg-[#374050] text-white font-roboto">
            <div class="flex mb-4 justify-between">
                <div class="h2 font-semibold text-[22px] uppercase">ID оборудования {{ props.equipment.id }}</div>
                <div class="flex">
                    <!-- <EditProduct  @sendshowOPM="closeProductModal" :product="{ id: view.id, article: view.article, name: view.name, status: view.status, data: view.data }"/> -->
                    <button  @click="destroy(props.equipment.id) & closeProductModal">
                        <img class="self-center lg:w-5 mr-3" src="/img/recycle2.png"></img>
                    </button>

                    <p class="text-2xl hover:cursor-pointer" @click="closeProductModal">&#x2715;</p>
                </div>
            </div>
            <div class="flex gap-2">
                <p class="text text-[#ffffff99] lg:w-20">ID оборудования</p> 
                <p class="text text-[#ffffff]">{{ props.equipment.id }}</p>
            </div>
            <div class="flex gap-2 mt-2">
                <p class="text text-[#ffffff99] lg:w-20">Название</p>
                <p class="text text-[#ffffff]">{{ props.equipment.equipment_type.name }}</p>
            </div>
            <div class="flex gap-2 mt-2">
                <p class="text text-[#ffffff99] lg:w-20">Статус</p>
                <p class="text text-[#ffffff]">{{ props.equipment.sn }}</p>
            </div>
            <div class="flex gap-2 mt-2">
                <p class="text text-[#ffffff99] lg:w-20">Статус</p>
                <p class="text text-[#ffffff]">{{ props.equipment.comment }}</p>
            </div>
      </div>
    </Modal>
</template>
