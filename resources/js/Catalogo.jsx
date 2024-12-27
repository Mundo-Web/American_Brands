import React, { useEffect, useState, useRef } from 'react'
import { createRoot } from 'react-dom/client'
import CreateReactScript from './Utils/CreateReactScript'
import FilterContainer from './components/Filter/FilterContainer'
import ProductContainer from './components/Product/ProductContainer'
import { Fetch } from 'sode-extend-react'
import FilterPagination from './components/Filter/FilterPagination'
import arrayJoin from './Utils/ArrayJoin'
import ProductCard from './components/Product/ProductCard'
import { set } from 'sode-extend-react/sources/cookies'
import axios from 'axios'
import { Swiper, SwiperSlide } from 'swiper/react';




const Catalogo = ({ minPrice, maxPrice, categories, tags, attribute_values, id_cat: selected_category, tag_id, subCatId, marcas, marcas_id, colores, sizes, media }) => {
  const take = 12
  const [items, setItems] = useState([]);
  const [filter, setFilter] = useState({});
  const [totalCount, setTotalCount] = useState(0);
  const [currentPage, setCurrentPage] = useState(1);
  const [showModal, setShowModal] = useState(false);
  const is_proveedor = useRef(false);
  const cancelTokenSource = useRef(null);
  const [hasTag51, setHasTag51] = useState(false);

  useEffect(() => {
    const script = document.createElement('script');
    script.src = "js/notify.extend.min.js";
    script.async = true;
    document.body.appendChild(script);

    return () => {
      document.body.removeChild(script);
    };
  }, []);

  useEffect(() => {
    // Leer el parámetro 'tag' de la URL
    const params = new URLSearchParams(window.location.search);
    const tag = params.get('tag');
    //const color = params.get('color');
    

    // Actualizar el filtro con el 'tag_id' si existe
    if (tag) {
      setFilter(prevFilter => ({
        ...prevFilter,
        'txp.tag_id': [tag]
      }));

      if (tag === '51') {
        setHasTag51(true);
      }    
    }

    // Actualizar el filtro con el 'marcas_id' si existe
    if (marcas_id) {
      setFilter(prevFilter => ({
        ...prevFilter,
        'marca_id': [marcas_id]
      }));
    }

    // if (color) {
    //   setFilter(prevFilter => ({
    //     ...prevFilter,
    //     'color': [color]

    //   }));
    // }

    // Si hay una categoría seleccionada, agregarla al filtro
    if (selected_category) {
      setFilter(prevFilter => ({
        ...prevFilter,
        category_id: [selected_category]
      }));
    }


  }, [selected_category]);

  useEffect(() => {
    setCurrentPage(1);
    getItems();
  }, [filter]);

  useEffect(() => {
    getItems();
  }, [currentPage]);

  useEffect(() => {
    if (subCatId !== null) {
      setFilter({ ...filter, subcategory_id: [subCatId] });
    }
  }, []);

  const getItems = async () => {
    // Cancelar la solicitud anterior si existe
    if (cancelTokenSource.current) {
      cancelTokenSource.current.cancel('Operation canceled due to new request.');
    }

    // Crear un nuevo token de cancelación
    cancelTokenSource.current = axios.CancelToken.source();

    const filterBody = [];

    if (filter.maxPrice || filter.minPrice) {
      if (filter.maxPrice && filter.minPrice) {
        filterBody.push([
          [
            ['precio', '>=', filter.minPrice],
            'or',
            [
              ['descuento', '>=', filter.minPrice],
              'and',
              ['descuento', '<>', 0]
            ]
          ],
          'and',
          [
            ['precio', '<=', filter.maxPrice],
            'or',
            [
              ['descuento', '<=', filter.maxPrice],
              'and',
              ['descuento', '<>', 0]
            ]
          ]
        ]);
      } else if (filter.minPrice) {
        filterBody.push([
          ['precio', '>=', filter.minPrice],
          'or',
          [
            ['descuento', '>=', filter.minPrice],
            'and',
            ['descuento', '<>', 0]
          ]
        ]);
      } else if (filter.maxPrice) {
        filterBody.push([
          ['precio', '<=', filter.maxPrice],
          'or',
          [
            ['descuento', '<=', filter.maxPrice],
            'and',
            ['descuento', '<>', 0]
          ]
        ]);
      }
    }

    if (filter['txp.tag_id'] && filter['txp.tag_id'].length > 0) {
      const tagsFilter = [];
      filter['txp.tag_id'].forEach((x, i) => {
        if (i === 0) {
          tagsFilter.push(['txp.tag_id', '=', x]);
        } else {
          tagsFilter.push('or', ['txp.tag_id', '=', x]);
        }
      });
      filterBody.push(tagsFilter);
    }


    if (filter['marca_id'] && filter['marca_id'].length > 0) {
      const marcasFilter = [];
      filter['marca_id'].forEach((x, i) => {
        if (i === 0) {
          marcasFilter.push(['marca_id', '=', x]);
        } else {
          marcasFilter.push('or', ['marca_id', '=', x]);
        }
      });
      filterBody.push(marcasFilter);
    }



    if (filter['color'] && filter['color'].length > 0) {
      const coloresFilter = [];
      filter['color'].forEach((x, i) => {
        if (i === 0) {
          coloresFilter.push(['color', '=', x]);
        } else {
          coloresFilter.push('or', ['color', '=', x]);
        }
      });
      filterBody.push(coloresFilter);
     
    }


    if (filter['peso'] && filter['peso'].length > 0) {
      const sizesFilter = [];
      filter['peso'].forEach((x, i) => {
        if (i === 0) {
          sizesFilter.push(['peso', '=', x]);
        } else {
          sizesFilter.push('or', ['peso', '=', x]);
        }
      });
      filterBody.push(sizesFilter);
     
    }
      

    for (const key in filter) {
      if (!key.startsWith('attribute-')) continue;
      if (filter[key].length === 0) continue;
      const [, attribute_id] = key.split('-');
      const attributeFilter = [];
      filter[key].forEach((x, i) => {
        if (i === 0) {
          attributeFilter.push(['apv.attribute_value_id', '=', x]);
        } else {
          attributeFilter.push('or', ['apv.attribute_value_id', '=', x]);
        }
      });
      filterBody.push([
        ['a.id', '=', attribute_id],
        'and',
        attributeFilter
      ]);
    }

    if (filter['category_id'] && filter['category_id'].length > 0) {
      const categoryFilter = [];
      filter['category_id'].forEach((x, i) => {
        if (i === 0) {
          categoryFilter.push(['categoria_id', '=', x]);
        } else {
          categoryFilter.push('or', ['categoria_id', '=', x]);
        }
      });
      filterBody.push(categoryFilter);
    }

    if (filter['subcategory_id'] && filter['subcategory_id'].length > 0) {
      const subcategoryFilter = [];
      filter['subcategory_id'].forEach((x, i) => {
        if (i === 0) {
          subcategoryFilter.push(['subcategory_id', '=', x]);
        } else {
          subcategoryFilter.push('or', ['subcategory_id', '=', x]);
        }
      });
      filterBody.push(subcategoryFilter);
    }

    try {
      const { status, data: result } = await axios.post('/api/products/paginate', {
        requireTotalCount: true,
        filter: arrayJoin([...filterBody, ['products.visible', '=', true]], 'and'),
        take,
        hasTag51,
        skip: take * (currentPage - 1)
      }, {
        headers: {
          'Content-Type': 'application/json'
        },
        cancelToken: cancelTokenSource.current.token
      });

      is_proveedor.current = result?.is_proveedor ?? false;

      setItems(result?.data ?? []);
      setTotalCount(result?.totalCount ?? 0);
    } catch (error) {
      if (axios.isCancel(error)) {
        console.log('Request canceled', error.message);
      } else {
        // Manejar otros errores
        console.error(error);
      }
    }
  };

  const attributes = attribute_values.reduce((acc, item) => {
    // If the attribute_id does not exist in the accumulator, create a new array for it
    if (!acc[item.attribute_id]) {
      acc[item.attribute_id] = [];
    }
    // Add the current item to the array corresponding to its attribute_id
    acc[item.attribute_id].push(item);
    return acc;
  }, {});

  const categoryDetails = categories.find(category => category.id === Number(selected_category));
  const imginstagram = 'images/img/banner_AB.png';
  
  const filteredMedia = media.filter(
    (item) => item.media_type === "IMAGE" || item.media_type === "CAROUSEL_ALBUM"
  );

  return (<>
   <div>
  
    <form className="flex flex-col lg:flex-row gap-6  mx-auto font-Helvetica_Light font-bold w-full p-5 lg:p-10">
      {/* sticky */}
      <section className="hidden lg:flex md:flex-col gap-4 md:basis-3/12 bg-white p-6 rounded-lg h-max top-2">
        <FilterContainer setFilter={setFilter} filter={filter} minPrice={minPrice ?? 0} maxPrice={maxPrice ?? 0} categories={categories} tags={tags} marcas={marcas} marcas_id={marcas_id} attribute_values={Object.values(attributes)} selected_category={selected_category} tag_id={tag_id} colores={colores} sizes={sizes}/>
      </section>
      <section className="flex flex-col gap-6 md:basis-9/12">
        <div className="w-full bg-white rounded-lg font-medium flex flex-row justify-between items-center px-2 py-3">
          <div className='flex flex-col xl:flex-row  justify-start xl:justify-between items-start gap-2 '>
            <span className="font-normal text-[17px] text-[#666666] xl:ml-3">
              Mostrando {((currentPage - 1) * take) + 1} - {currentPage * take > totalCount ? totalCount : currentPage * take} de {totalCount} resultados
            </span>
            <button type="button" className='lg:hidden text-black' onClick={() => setShowModal(true)}> Mostrar Filtros</button>
          </div>
        </div>
        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-3 gap-4 md:pr-4">
          {items.map((item, i) => <ProductCard key={`product-${item.id}`} item={item} bgcolor={'bg-white'} is_reseller={is_proveedor.current} />)}
        </div>
        <div className="w-full font-medium flex flex-row justify-center items-center">
          <FilterPagination current={currentPage} setCurrent={setCurrentPage} pages={Math.ceil(totalCount / take)} />
        </div>
      </section>
      {/* modal */}

      {showModal && (<div className="fixed z-40 top-0 left-0 w-full h-full bg-black bg-opacity-50 flex justify-center items-center max-h-[76vh] p-5" id="modal">
        {/* btn para cerrar modal */}
        <div className="z-50 flex items-center content-center justify-center absolute  p-4 bg-black rounded-full h-6 w-6" style={{ top: '20px', right: '20px' }}>
          <button type='button' onClick={() => setShowModal(false)} className="text-white text-md ">X</button>

        </div>

        <div className='flex flex-col gap-4 w-full bg-white p-6 rounded-lg top-2 overflow-y-auto mt-32' style={{ maxHeight: '90vh', maxWidth: "85vh" }}>
          <FilterContainer setFilter={setFilter} filter={filter} minPrice={minPrice ?? 0} maxPrice={maxPrice ?? 0} categories={categories} tags={tags} attribute_values={Object.values(attributes)} selected_category={selected_category} tag_id={tag_id} colores={colores} sizes={sizes} marcas={marcas} marcas_id={marcas_id} />
        </div>

      </div>)}


    </form>
    
      {/* <section className="w-full px-[5%] relative mx-auto pt-12 lg:pt-16">
                <h2 className="text-center font-Urbanist_Black text-2xl lg:text-3xl text-black">FOLLOW US <span class="font-Urbanist_Regular"> ON </span> 
                <span className="font-Urbanist_Regular italic"> @americanbrandspe </span></h2>
      </section> */}
      
      <section className="w-full relative mx-auto pt-12 lg:pt-16">
        <Swiper
          spaceBetween={0}
          slidesPerView={5}
          loop={true}
          breakpoints={{
            0: {
              slidesPerView: 1,
              spaceBetween: 0,
            },
            600: {
              slidesPerView: 2,
              spaceBetween: 0,
            },
            768: {
              slidesPerView: 3,
              spaceBetween: 0,
            },
            1024: {
              slidesPerView: 4,
              spaceBetween: 0,
            },
            1350: {
              slidesPerView: 5,
              spaceBetween: 0,
            },
          }}
          className="instagram h-max"
        >
          {filteredMedia.slice(0, 12).map((item, index) => (
            <SwiperSlide key={index}>
              <div className="relative group aspect-square h-full">
                <img
                  src={item.media_url}
                  alt="Image"
                  className="object-cover h-full w-full"
                />
                <a
                  href={item.permalink}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="opacity-0 hover:cursor-pointer group-hover:opacity-60 duration-300 absolute inset-0 flex justify-center items-center bg-black bg-opacity-70"
                ></a>
              </div>
            </SwiperSlide>
          ))}
        </Swiper>
      </section>
      
      {/* <section className="w-full relative mx-auto pt-12 lg:pt-16">
        <Swiper
          spaceBetween={0}
          slidesPerView={5}
          loop={true}
          className="instagram h-max"
        >
          {media.slice(0, 6).map((item, index) => (
            <SwiperSlide key={index}>
              <div className="relative group aspect-square h-full">
                {item.media_type === 'IMAGE' || item.media_type === 'CAROUSEL_ALBUM' ? (
                  <>
                    <img
                      src={item.media_url}
                      alt="Image"
                      className="object-cover h-full w-full"
                    />
                    <a
                      href={item.permalink}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="opacity-0 hover:cursor-pointer group-hover:opacity-60 duration-300 absolute inset-0 flex justify-center items-center bg-black bg-opacity-70"
                    ></a>
                  </>
                ) : item.media_type === 'VIDEO' ? (
                  <div className="h-full overflow-hidden">
                    <video className="min-h-full min-w-full" controls>
                      <source src={item.media_url} type="video/mp4" />
                      Your browser does not support the video tag.
                    </video>
                    <a
                      href={item.permalink}
                      target="_blank"
                      rel="noopener noreferrer"
                      className="opacity-0 hover:cursor-pointer group-hover:opacity-60 duration-300 absolute inset-0 flex justify-center items-center bg-black bg-opacity-70"
                    ></a>
                  </div>
                ) : null}
              </div>
            </SwiperSlide>
          ))}
        </Swiper>
      </section> */}
        
    </div>
  </>)
}

CreateReactScript((el, properties) => {
  createRoot(el).render(<Catalogo {...properties} />);
})