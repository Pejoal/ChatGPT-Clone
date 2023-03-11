<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

const input = ref(null);

let props = defineProps({
  botAnswers: {
    type: Array,
    default: [],
  },
});

const form = useForm({
  message: "",
});

const submit = () => {
  axios
    .post(route("chat.store"), {
      message: form.message,
    })
    .then((response) => {
      //Save the response in the botAnswers array to display on the chat view
      props.botAnswers.push(response.data);
      // props.botAnswers.push(...response.data);
      // props.botAnswers.msgs.push(response.data.msg);
      // props.botAnswers.answers.push(response.data.answer);
      form.reset('message');
      input.value.focus();
    });
};
</script>

<template>
  <Head title="Start Chat" />

  <AuthenticatedLayout>
    <template #header>
      <h2
        class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"
      >
        Start Chat
      </h2>
    </template>

    <div class="py-12">
      <div class="mx-auto sm:px-6 lg:px-8">
        <div
          class="w-3/4 mx-auto bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg"
        >
          <form @submit.prevent="submit" class="py-2 px-4 rounded-lg">
            <div>
              <InputLabel
                for="message"
                value="Message"
                class="text-center my-2"
              />

              <TextInput
                id="message"
                type="message"
                class="px-4 mt-1 block w-full"
                v-model="form.message"
                required
                autofocus
                autocomplete="message"
                ref="input"
              />

              <InputError class="mt-2" :message="form.errors.message" />
            </div>

            <div class="flex items-center justify-end mt-4">
              <PrimaryButton
                class="ml-4"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
              >
                Submit
              </PrimaryButton>
            </div>
          </form>
        </div>
        <section v-if="props.botAnswers.length > 0" class="border border-gray-200 rounded-lg my-3">
          <!-- {{ props.botAnswers }} -->
          <section v-for="botAnswer, index in props.botAnswers" :key="index" class="py-2 px-4">
            <p class="indent-2 text-gray-300">{{ botAnswer[0] }}</p>
            <p class="indent-4 text-white">ChatGPT: {{ botAnswer[1] }}</p>
            <div class="w-1/2 border-b py-2 mx-auto"></div>
          </section>
        </section>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
