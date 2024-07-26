<script setup>
    import { ref } from 'vue';
    import { onMounted } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import { useForm } from '@inertiajs/vue3';


    const showAddProductModal = ref(false);

    const addProductModal = () => {
    showAddProductModal.value = true;
    }

const emit = defineEmits(['sendshowOPM']);

const showOPM = true;

const closeModal = () => {
    showAddProductModal.value = false;
    emit('sendshowOPM', showOPM);
}

const form = useForm({
   equipmentsStor: [],
})

let equipmentsStor = form.equipmentsStor;

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
                })
}

function store() {
            console.log(equipmentsStor);
            axios.post('/api/equipment', { data: form.equipmentsStor })
                .then(res => {
                    equipmentsStor = null
                    form.reset()
                    closeModal()
                })
            .catch( e => {
                errors = e.response.data.errors
                console.log(errors);
            })
        }

const addField = () => {
      form.equipmentsStor.push({ equipment_type_id: '', sn: '', comment: '' });
      console.log(form.equipmentsStor);
    }

const delField = (index) => {
    equipmentsStor.splice(index);
}       



</script>

<template>
    <button type="button" class="text-xl text-white mt-5 bg-[#0FC5FF] py-2 px-12 rounded-md" @click="addProductModal">Добавить</button>
    <Modal :show="showAddProductModal" @close="closeModal" >
        <div class="p-6 bg-[#374050] text-white font-roboto">
            <div class="flex justify-between">
                <div class="h2 font-bold text-[20px]">Добавить оборудование</div>
                <p class="text-2xl hover:cursor-pointer" @click="closeModal">&#x2715;</p>
            </div>
            
            <form class="flex flex-col " @submit.prevent="store">
                <div class="flex flex-col" v-for="(equipment_type_id, sn, comment ) in form.equipmentsStor" :key="equipment_type_id">
                    <!-- equipmentType -->
                    <label class="mt-4 mb-1" for="{{ equipment_type_id }}">Тип оборудования</label>
                    <select class="h-9 rounded-md text-black text-[11px]" name="equipment_type_id" id="{{ equipment_type_id }}"  v-model="equipment_type_id.equipment_type_id" >
                        <option style="width: 80%; height: 2.25rem; border-radius: 0.375rem;" v-for="et in equipmentTypes" :key="et.id" :value="et.id">{{ et.name }}</option>
                    </select>
                    <div v-if="errors.equipment_type_id">{{ errors.equipment_type_id }}</div>
                    <!-- serialNum -->
                    <label class="mt-2 mb-1" for="{{ sn }}">Серийный номер</label>
                    <input class="h-8 rounded-md text-black text-[11px]" id="{{ sn }}" type="sn" v-model="equipment_type_id.sn">
                    <div v-if="errors.sn">{{ errors.sn }}</div>
                    <!-- comment -->
                    <label class="mt-2 mb-1" for="{{ comment }}">Примечание</label>
                    <input class="h-8 rounded-md text-black text-[11px]" id="{{ comment }}" type="comment" v-model="equipment_type_id.comment">
                    <div v-if="errors.comment">{{ errors.comment }}</div>
                    <hr class="mt-10"></hr>
                </div>  
                <button class="mt-3 w-12 pb-1.5 text-4xl bg-[#0FC5FF]  rounded-full" type="button" @click="addField">+</button>              
                <!-- submit -->
                <button class="mt-5 bg-[#0FC5FF] py-2 px-12 rounded-md" type="submit">Добавить</button>
            </form>
        </div>   
    </Modal>
</template>
