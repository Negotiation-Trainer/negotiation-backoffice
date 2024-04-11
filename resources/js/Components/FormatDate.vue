<template>
    <span>
        {{ formattedDate }}
    </span>
</template>

<script>
import { computed } from 'vue';

export default {
    props: {
        timestamp: {
            type: [Number, String],
            required: true
        }
    },
    setup(props) {
        const formattedDate = computed(() => {
            return formatDate(props.timestamp);
        });

        const formatDate = (timestamp) => {
            const date = new Date(timestamp);
            const options = { day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            return date.toLocaleString('en-US', options);
        };

        return {
            formattedDate
        };
    }
};
</script>
