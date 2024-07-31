<script setup>
    import { ref, defineProps } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import { useForm } from '@inertiajs/vue3';
    import { onMounted } from 'vue';


    const showEditProductModal = ref(false);

    const emit = defineEmits(['sendshowOPM']);

    const props = defineProps({ equipment: Object });

    const showOPM = false;

    const editProductModal = () => {
    showEditProductModal.value = true;

}

const closeEditModal = () => {
    showEditProductModal.value = false;
    emit('sendshowOPM', showOPM);
}

const form = useForm({
    
        equipment_type_id: props.equipment.equipment_type.id,
        equipment_type: props.equipment.equipment_type,
        sn: props.equipment.sn,
        comment: props.equipment.comment
    
})



let equipmentsStor = form.equipmentsStor;

function update(id) {
         console.log(form.equipmentf); 
         axios.put(`/api/equipment/${id}`, { data: form } )
                .then(res => {
                 closeEditModal()
                })
            .catch( e => {
                console.log(e);
                
            })
        }

        let equipmentTypes = ref([]);

let errors = ref([]);

    onMounted(() => {
        getEquipmentTypes(); 
        
})

function getEquipmentTypes() {
  axios.get(`/api/equipment-type`)
                .then(res => {
                    equipmentTypes.value = res.data;
                    console.log(equipmentTypes);
                    
        form.equipmentf = props.equipment;
                })
}

</script>

<template>
    <img class="self-center w-10 mr-[3px] hover:cursor-pointer" src="/img/edit.png" @click="editProductModal"></img>
    <Modal :show="showEditProductModal" @close="closeEditModal" >
        <div class="p-6 bg-[#374050] text-white font-roboto">
            <div class="flex justify-between">
                <div class="h2 font-bold text-[20px]">Редактирование оборудования</div>
                <p class="text-2xl hover:cursor-pointer" @click="closeEditModal">&#x2715;</p>
            </div>
            
            <form class="flex flex-col " @submit.prevent="update(props.equipment.id)">
                <div class="flex flex-col">
                    <!-- equipmentType -->
                    <label class="mt-4 mb-1" for="equipment_type_id">Тип оборудования</label>
                    <select class="h-9 rounded-md text-black text-[11px]" name="equipment_type_id" id="equipment_type_id" v-model="form.equipment_type.id" >
                        <option style="width: 80%; height: 2.25rem; border-radius: 0.375rem;" v-for="et in equipmentTypes" :key="et.id" :value="et.id">{{ et.name }}</option>
                    </select>
                    <!-- <div v-if="errors.equipment_type_id">{{ errors.equipment_type_id }}</div> -->
                    <!-- serialNum -->
                    <label class="mt-2 mb-1" for="sn">Серийный номер</label>
                    <input class="h-8 rounded-md text-black text-[11px]" id="sn" type="sn" v-model="form.sn">
                    <!-- <div v-if="errors.sn">{{ errors.sn }}</div> -->
                    <!-- comment -->
                    <label class="mt-2 mb-1" for="comment">Примечание</label>
                    <input class="h-8 rounded-md text-black text-[11px]" id="comment" type="comment" v-model="form.comment">
                    <!-- <div v-if="errors.comment">{{ errors.comment }}</div> -->
                    <hr class="mt-10"></hr>
                </div>                
                <!-- submit -->
                <button class="mt-5 bg-[#0FC5FF] py-2 px-12 rounded-md" type="submit">Редактировать</button>
            </form>
        </div>   
    </Modal>
</template>
