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
                            @click="agePet(animal)"
                            class="pet__icon"
                            :style="{
                                width: calculateAnimalSize(animal)
                            }"
                            :src="`/images/pets/${animal.kind}.svg`"
                            :alt="`${animal.name} (${animal.kind})`"
                        />
                        <p class="pet__name">{{ animal.name }} ({{ animal.age }})</p>
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

            let dur = (this.animalKinds.length) ? 600 : 0;

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
        async loadAnimals() {
            this.loadingAnimals = true;
            try {
                let response = await axios.get(`/animals`);
                let maxSizeOfAnimals = response.data.reduce((acc, item) => acc = acc > item.size ? acc : item.size, 0);

                if(maxSizeOfAnimals * this.raito > this.maxSize){
                    this.raito = this.maxSize / maxSizeOfAnimals;
                } else{
                    this.raito = 50
                }

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
                } else{
                    isError = true
                }
            } catch (error) {
                isError = true
            }
            
            this.isShowPopup = false;
            
            if(isError) alert('Произошла ошибка. Попробуйте позднее');
        },
        async agePet(animal) {
            let isError = false;
            try {
                let response = await axios.post(`/animals/age`,{
                    'name': animal.name,
                });

                if(response.data.data === "ok"){
                    this.loadAnimal(animal.name);
                } else{
                    isError = true
                }
            } catch (error) {
                isError = true
            }
            
            if(isError) alert('Произошла ошибка. Попробуйте позднее');
        },
        async loadAnimal(name) {
            try {
                let response = await axios.get(`/animals/${name}`);
                let newAnimal = response.data;
                Object.assign(this.animals.find(e =>  e.name == newAnimal.name), newAnimal)
            } catch (error) {
                alert('Произошла ошибка. Попробуйте позднее');
            }
        },
    },
    created() {
        this.maxSize = window.innerWidth > 1050 ? 1050 : window.innerWidth - 100
        this.loadAnimals();
        this.loadAnimalKinds()

        setInterval(() => {
            if(this.animals && this.animals.length){
                this.animals.forEach(e => {
                    let kind = this.animalKinds.find(item => item.kind == e.kind)

                    if(kind.max_size > e.size && kind.max_age > e.age){
                        this.agePet(e)
                    }
                })
            }
        }, 1000)
    }
};
</script>
