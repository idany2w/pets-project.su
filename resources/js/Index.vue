<template>
    <div class="container">
        <div class="index">
            <div class="index__top">
                <div
                    class="buttons-toggler"
                    :class="{ 'buttons-toggler--loading': loadingAnimalKinds }"
                >
                    <button
                        class="buttons-toggler__btn"
                        type="Button"
                        title="Открыть"
                        @click="loadAnimalKinds"
                    ></button>
                    <div class="buttons-toggler__inner">
                        <div 
                            class="buttons-toggler__content"
                            :class="{ 'buttons-toggler__content--show': loadedAnimalKinds }"
                        >
                            <button class="add-pet-btn" type="button" v-for="animalKind in animalKinds" :key="animalKind.kind">
                                <img
                                    class="add-pet-btn__icon"
                                    :src="`/images/pets/${animalKind.kind}.svg`"
                                    :alt="`${animalKind.kind}`"
                                    @click="showPopup(animalKind.kind)"
                                />
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="index__content">
                <div class="pets" v-if="animals.length">
                    <div class="pet" v-for="animal in animals" :key="animal.name">
                        <img
                            class="pet__icon"
                            :style="{
                                width: calculateAnimalSize(animal)
                            }"
                            :src="`/images/pets/${animal.kind}.svg`"
                            :alt="`${animal.name} (${animal.kind})`"
                        />
                    </div>
                </div>
            </div>
        </div>
        <div class="add-pet-popup" v-if="isShowPopup" @click="hidePopup()">
            <div class="add-pet-popup__inner" @click.stop="">
                <p class="add-pet-popup__title">Введите имя питомца</p>
                <input type="text" class="add-pet-popup__input" v-model="petModel.name">
                <button type="button" class="add-pet-popup__btn" @click="storePet">Создать</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            animalKinds: [],
            loadingAnimalKinds: false,
            loadedAnimalKinds: false,

            animals: [],
            loadingAnimals: false,

            raito: 50,
            maxSize: 0,

            isShowPopup: false,
            petModel: {
                name: '',
                kind: '',
            }
        };
    },
    methods: {
        async loadAnimalKinds(e) {
            this.loadingAnimalKinds = true;
            this.loadedAnimalKinds = false;

            let dur = (this.animals.length) ? 600 : 0;

            setTimeout(async () => {
                try {
                    let response = await axios.get(`/animal_kinds`);
                    this.animalKinds = response.data;
                } catch (error) {
                    alert('Произошла ошибка. Попробуйте позднее');
                }
                        
                setTimeout(() => {
                    this.loadingAnimalKinds = false;
                    this.loadedAnimalKinds = true;
                }, 100)
            }, dur)
        },
        async loadAnimals(e) {
            this.loadingAnimals = true;
            try {
                let response = await axios.get(`/animals`);
                this.animals = response.data;
            } catch (error) {
                alert('Произошла ошибка. Попробуйте позднее');
            }

            this.loadingAnimals = false;
        },
        calculateAnimalSize(animal) {
            if(animal.size * this.raito > this.maxSize){
                this.raito = this.maxSize / animal.size;
            }
            return (animal.size * this.raito) + 'px';
        },
        showPopup(kind){
            this.petModel.kind = kind;
            this.isShowPopup = true;
        },
        hidePopup(){
            this.isShowPopup = false;
        },
        async storePet() {
            const name = this.petModel.name;
            const kind = this.petModel.kind;

            this.petModel.name = null;
            this.petModel.kind = null;

            let isError = false;

            try {
                let response = await axios.post(`/animals`,{
                    'name': name,
                    'kind': kind,
                });

                if(response.data.data === "ok"){
                    this.loadAnimals()
                } else[
                    isError = true
                ]
            } catch (error) {
                isError = true
            }
            
            this.isShowPopup = false;
            
            if(isError) alert('Произошла ошибка. Попробуйте позднее');
        }
    },
    created() {
        this.maxSize = window.innerWidth > 1050 ? 1050 : window.innerWidth - 50
        this.loadAnimals()
    }
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

.add-pet-popup{
    position:fixed;
    z-index: 5;
    background-color: rgba(0, 0, 0, .5);
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;

    display: flex;
    overflow-y: auto;
    overflow-x: hidden;
}

.add-pet-popup__inner{
    border-radius: 24px;
    padding: 24px;
    background-color: #fff;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    gap: 10px;

    max-width: 300px;
    width: 90%;
}
.add-pet-popup__title{
    font: 18px sans-serif;
    font-weight: bold;
    flex-grow: 1;
    flex-basis: 100%;
    margin: 0
}

.add-pet-popup__input{
    flex-basis: calc(100% - 70px);
    margin: 0;
    padding: 0;
}
.add-pet-popup__btn{
    flex-basis: 60px;
    background-color: #3E2723;
    color: #fff;
    padding: 4px;
}
</style>
