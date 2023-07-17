<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {ref, onMounted, onUnmounted} from "vue";

const user = usePage().props.user.data;
let remappedEvents = ref([]);
let displayedItems = ref(100);
const itemsPerLoad = 100;

onMounted(() => {
    remappedEvents.value = sortAndMapUserEvents(user);
    window.addEventListener('scroll', loadMoreItems);
    console.log(user, remappedEvents.value)

});

onUnmounted(() => {
    window.removeEventListener('scroll', loadMoreItems);
});

/**
 * the listening condition that would increase the number of viewable items in the view
 */
const loadMoreItems = () => {
    if (window.innerHeight + window.pageYOffset >= document.body.offsetHeight) {
        displayedItems.value += itemsPerLoad;
    }
};

/**
 *
 * set each row with either respective text or color according to event type
 *
 * @param event
 * @param getText
 * @returns {string|string}
 */
const eventRespectiveAttributes = (event, getText = false) => {
    const type = event.type;
    let color = '';
    let text = '';

    switch (type) {
        case 'followers':
            color = 'bg-pink-200';
            text = `${event.name} has followed you!`
            break;
        case 'subscribers':
            color = 'bg-sky-200';
            text = `you just got a '${event.tierName}' subscription from ${event.name}`
            break;
        case 'merch_sales':
            color = 'bg-emerald-200';
            text = `${event.name} has bought ${+ event.amount} ${event.item_name} for ${event.currencySymbol+event.price}!`
            break;
        case 'donations':
            color = 'bg-violet-200';
            text = `${event.name} donated ${event.currencySymbol+event.amount} to you!`
            break;
        default:
            color = 'bg-blue-200';
            break;
    }

    return getText ? text : color;
}

/**
 *
 * remapping models into a single list, sorted by created_at and each object would have an added "type" to signify
 * context
 *
 * @param data
 * @returns {*[]}
 */
const sortAndMapUserEvents = (data) => {
    const {name, email, events} = data;
    let tempEvents = [];

    Object.keys(events).forEach(eventType => {
        const eventTypeData = events[eventType];

        eventTypeData.forEach(event => {
            const remappedEvent = {
                type: eventType,
                ...event,
            };
            tempEvents.push(remappedEvent);
        });
    });

    return tempEvents.sort((a, b) => new Date(a.created_at) - new Date(b.created_at));
};

/**
 *
 * update an event's read status
 *
 * @param eventId
 * @param eventType
 * @param eventRead
 * @returns {Promise<void>}
 */
const updateEventStatus = async (eventId, eventType, eventRead) => {
    try {
        const response = await axios.patch('/dashboard', {
            eventId,
            eventType,
            eventRead
        });

        console.log(response.data);

        const eventToUpdate = remappedEvents.value.find(event => event.id === eventId);

        if (eventToUpdate) {
            eventToUpdate.read = !eventToUpdate.read;
        }
    } catch (error) {
        console.error(error);
    }
};
</script>
<template>
    <Head title="Dashboard"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div v-if="remappedEvents.length" v-for="event in remappedEvents.slice(0, displayedItems)"
                         :key="event.id"
                         :class="`flex items-center border-b p-4 sm:p-8 ${eventRespectiveAttributes(event)} shadow rounded-lg m-5`"
                    >
                        <div class="w-2 h-2 rounded-full bg-gray-500 mr-5"></div>

                        <div class="flex-grow">
                            <p class="text-gray-800">{{ eventRespectiveAttributes(event, true) }}</p>
                        </div>
                        <div class="">
                            <input id="read-event"
                                   type="checkbox"
                                   :value="event.read"
                                   :checked="event.read"
                                   @click="updateEventStatus(event.id, event.type, event.read)"
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="read-event"
                                   class="ml-2 text-sm font-medium text-gray-900 text-xs capitalize"
                            >
                                read
                            </label>
                        </div>
                    </div>
                    <div v-else class="flex justify-center items-center border-b p-4 sm:p-8 shadow rounded-lg m-5">
                            <p class="text-gray-800">no events yet, getsome!</p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
