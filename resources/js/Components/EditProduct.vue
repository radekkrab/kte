<script setup>
    import { ref, defineProps } from 'vue';
    import Modal from '@/Components/Modal.vue';
    import { useForm } from '@inertiajs/vue3';


    const showEditProductModal = ref(false);

    const emit = defineEmits(['sendshowOPM']);

    const props = defineProps({ product: Object });

    const showOPM = false;

    const editProductModal = () => {
    showEditProductModal.value = true;

}

const closeEditModal = () => {
    showEditProductModal.value = false;
    emit('sendshowOPM', showOPM);
}

const form = useForm({
  id: props.product.id,
  article: props.product.article,
  name: props.product.name,
  status: props.product.status,
  colorSize: props.product.data,

})

const addField = () => {
      form.colorSize.push({ name: '', value: '' });
    }

const delField = (index) => {
    form.colorSize.splice(index);
}


</script>

<template>
    <img class="self-center w-5 mr-[3px] hover:cursor-pointer" src="/img/edit.png" @click="editProductModal"></img>
    <Modal :show="showEditProductModal" @close="closeEditModal" >
        <div class="p-6 bg-[#374050] text-white font-roboto">
            <div class="flex justify-between">
                <div class="h2 font-bold text-[20px]">Редактировать {{ props.product.name }}</div>
                <p class="text-2xl hover:cursor-pointer" @click="closeEditModal">&#x2715;</p>
            </div>

            <form class="flex flex-col items-start" @submit.prevent="form.put(route('product.update', props.product.id),  { onSuccess: () => form.reset() & closeEditModal() })">

                <!-- article -->
                <label class="text-[9px] mt-5 mb-1" for="article">Артикул</label>
                <input class="w-4/5 h-8 rounded-md text-black text-[11px]" id="article" type="text" v-model="form.article" :disabled = "$page.props.auth.user.roles[0] !== 'admin'">
                <div v-if="form.errors.article">{{ form.errors.article }}</div>
                <!-- name -->
                <label class="text-[9px] mt-4 mb-1" for="name">Название</label>
                <input class="w-4/5 h-8 rounded-md text-black text-[11px]" id="name" type="text" v-model="form.name">
                <div v-if="form.errors.name">{{ form.errors.name }}</div>
                <!-- status -->
                <label class="text-[9px] mt-4 mb-1" for="status">Статус</label>
                <input class="w-4/5 h-8 rounded-md text-black text-[11px]" id="status" type="text" v-model="form.status" value="Доступен">
                <div v-if="form.errors.status">{{ form.errors.status }}</div>
                 <!-- atributes -->
                <h3 class="font-bold text-[14px] mt-3 mb-3">Атрибуты</h3>
                  <div class="flex gap-3" v-for="(field, index) in form.colorSize" :key="index">
                    <div class="mb-2">
                        <label class="text-[9px] mt-6 mb-1" for="{{ field }}">Название</label>
                        <input class="block w-56 h-8 rounded-md text-black text-[11px]" id="{{ field }}" type="text" v-model="field.name">
                    </div>
                    <div>
                        <label class="text-[9px] mt-6 mb-1" for="{{ index }}">Значение</label>
                        <input class="block w-56 h-8 rounded-md text-black text-[11px]" id="{{ index }}" type="text" v-model="field.value">
                    </div>
                    <img class="self-center mt-3" src="/img/recycle.png" @click="delField(index)"></img>
                    </div>
                   <button class="mt-3 text-[9px] text-[#0FC5FF] border-b border-dashed border-[#0FC5FF]" type="button" @click="addField">+ Добавить атрибут</button>
                <!-- submit -->
                <button class="text-[11px] mt-5 bg-[#0FC5FF] py-2 px-12 rounded-md" type="submit" :disabled="form.processing">Сохранить</button>
            </form>
        </div>
    </Modal>
</template>
