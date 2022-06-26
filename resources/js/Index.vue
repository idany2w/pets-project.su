<template>
    <div class="container">
        <div class="index">
            <div class="index__top">
                <div
                    class="buttons-toggler"
                    :class="{ 'buttons-toggler--loading': togglerLoading }"
                >
                    <button
                        class="buttons-toggler__btn"
                        type="Button"
                        title="Открыть"
                        @click="loadPets"
                    ></button>
                    <div class="buttons-toggler__inner">
                        <div 
                            class="buttons-toggler__content"
                            :class="{ 'buttons-toggler__content--show': petsLoaded }"
                        >
                            <button class="add-pet-btn" type="button" v-for="pet in pets" :key="pet.name">
                                <img
                                    class="add-pet-btn__icon"
                                    :src="`/images/pets/${pet.kind}.svg`"
                                    :alt="`${pet.name} (${pet.kind})`"
                                />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="index__content">
                <div class="pets" v-if="pets.length">
                    <div class="pet" v-for="pet in pets" :key="pet.name">
                        <img
                            class="pet__icon"
                            :src="`/images/pets/${pet.kind}.svg`"
                            :alt="`${pet.name} (${pet.kind})`"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            togglerLoading: false,
            petsLoaded: false,
            raito: 1,
            pets: []
        };
    },
    methods: {
        async loadPets(e) {
            this.togglerLoading = true;
            this.petsLoaded = false;

            let dur = (this.pets.length) ? 600 : 0;

            setTimeout(() => {
                setTimeout(() => {
                    this.pets = [
                        {
                            "kind": "cat",
                            "max_size": 15,
                            "max_age": 30,
                            "growth_factor": 3,
                        },
                        {
                            "kind": "dog",
                            "max_size": 50,
                            "max_age": 30,
                            "growth_factor": 4
                        },
                        {
                            "kind": "bird",
                            "max_size": 1,
                            "max_age": 5,
                            "growth_factor": 5
                        },
                        {
                            "kind": "mi",
                            "max_size": 160,
                            "max_age": 20,
                            "growth_factor": 5
                        },
                    ];
                    
                    setTimeout(() => {
                        this.togglerLoading = false;
                        this.petsLoaded = true;
                    }, 100)
                }, 1000);
            }, dur)

        },
    },
};
</script>

<style>
.index {
    min-height: 100vh;
    padding: 50px 0;
    display: flex;
    flex-direction: column;
    gap: 50px
}

.index__content{
    flex-shrink: 0;
    flex-grow: 1;
    display: flex;
    flex-direction: column;
}

.buttons-toggler{
    transition: opacity 0.3s;
    display: flex;
    overflow: hidden;
}

.buttons-toggler__btn {
    width: 48px;
    height: 48px;
    border-radius: 48px;
    cursor: pointer;
    position: relative;
    z-index: 1;

    display: flex;
    align-items: center;
    justify-content: center;

    opacity: 1;
    background-color: #3e2723;
    
    margin-right: -48px;
}
.buttons-toggler__btn::before {
    content: "";
    display: block;
    width: 24px;
    height: 24px;
    background-image: url("data:image/svg+xml,%3Csvg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M19 13H13V19H11V13H5V11H11V5H13V11H19V13Z' fill='white'/%3E%3C/svg%3E%0A");
    pointer-events: none;
}
.buttons-toggler__inner{
    margin-left: 20px;
    overflow: hidden;
    height: 100%;
}
.buttons-toggler__content{
    display: flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px 4px 46px;
    border-radius: 0px 8px 8px 0px;

    background: #D7CCC8;

    transition: transform .3s, opacity .6s;

    transform: translateX(-50%);
    opacity: 0;
    pointer-events: none;
    height: 100%;
}
.buttons-toggler__content--show{
    transform: translateX(0%);
    opacity: 1;
    pointer-events: auto;
}

.buttons-toggler__content > *{
    width: 40px;
    transform: translateY(50%);
    transition: transform .3s, opacity .3s
}
.buttons-toggler__content--show > *{
    transform: translateY(0%);
    transition-delay: 5s;
}
.buttons-toggler__content > *:nth-child(1){transition-delay: .05s;}
.buttons-toggler__content > *:nth-child(2){transition-delay: .10s;}
.buttons-toggler__content > *:nth-child(3){transition-delay: .15s;}
.buttons-toggler__content > *:nth-child(4){transition-delay: .20s;}

.buttons-toggler--loading {
    pointer-events: none;
    opacity: 0.75;
}
.buttons-toggler--loading .buttons-toggler__btn::before {
    animation-name: spin;
    animation-duration: 1000ms;
    animation-iteration-count: infinite;
    animation-timing-function: linear;
}

.add-pet-btn{
    width: 40px;
    height: 40px;
    border-radius: 40px;
    background-color: #fff;
    border: 2px solid #3E2723;
    display: flex;
    align-items: center;
    justify-content: center;
}
.add-pet-btn__icon{
    width: 70%;
    height: 70%;
    object-fit: contain;
    object-position: center;
}

.pets{
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 30px;
    flex-grow: 1;
}
.pets > *{
    flex-grow: 1;
    flex-shrink: 0;
}

.pet{
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
