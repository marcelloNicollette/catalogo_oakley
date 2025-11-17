<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('cores', () => ({
        campos: [],
        init() {
            this.campos = @json($product->colors->map(function(c) {
                return {
                    color_name: c.color_name,
                    color_description: c.color_description,
                    color_code: c.color_code,
                    color_genero: c.genero,
                    color_collection_id: c.collection_id,
                    color_flag_product_id: c.flag_product_id,
                    color_numeracao_id: c.numeracao_id,
                };
            }));
            if (this.campos.length === 0) {
                this.adicionarCampo();
            }
        },
        adicionarCampo() {
            this.campos.push({ color_name: '', color_description: '', color_code: '', color_genero: 'Masculino', color_collection_id: '', color_flag_product_id: '', color_numeracao_id: '' });
        },
        removerCampo(index) {
            this.campos.splice(index, 1);
        }
    }));

    Alpine.data('caracteristicas', () => ({
        campos: [],
        init() {
            this.campos = @json($product->caracteristicas->map(function(c) {
                return {
                    caracteristica_title: c.title,
                    caracteristica_description: c.description,
                    caracteristica_destaque: c.destaque,
                };
            }));
            if (this.campos.length === 0) {
                this.adicionarCampo();
            }
        },
        adicionarCampo() {
            this.campos.push({ caracteristica_title: '', caracteristica_description: '', caracteristica_destaque: 0 });
        },
        removerCampo(index) {
            this.campos.splice(index, 1);
        }
    }));

    Alpine.data('links', () => ({
        campos: [],
        init() {
            this.campos = @json($links ?? []);
            if (this.campos.length === 0) {
                this.adicionarCampo();
            }
        },
        adicionarCampo() {
            this.campos.push({ link_title: '', link_url: '' });
        },
        removerCampo(index) {
            this.campos.splice(index, 1);
        }
    }));
});
</script>
