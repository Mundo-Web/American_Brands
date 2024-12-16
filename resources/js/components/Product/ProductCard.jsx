import Tippy from "@tippyjs/react";
import React, { useState } from "react";
import "tippy.js/dist/tippy.css";

const ProductCard = ({ item, width, bgcolor, is_reseller }) => {
    const [showAmbiente, setShowAmbiente] = useState(false);
    const [mainImage, setMainImage] = useState(item.imagen);

    const handleColorClick = (colorImage) => {
        setMainImage(colorImage);
    };

    const category = item.category;
    const tags = item.tags;
    const colors = item.colors;
    const marcas = item.marcas;

    return (
        <div
            // onMouseEnter={() => setShowAmbiente(true)}
            // onMouseLeave={() => setShowAmbiente(false)}
            className={`flex flex-col relative w-full md:${width} ${bgcolor}`}
            data-aos="zoom-in-left"
        >
            <div
                className={`${bgcolor} product_container basis-4/5 flex flex-col justify-center relative`}
            >
                <div className="absolute top-2 left-0 w-max">
                    <div className="flex flex-wrap gap-1.5">
                        {item.descuento > 0 && (
                            <div className="mb-1">
                                <span
                                    className="block font-Urbanist_Semibold text-[8px] md:text-[12px] bg-black py-1 px-3 flex-initial w-full text-center rounded-none text-white relative z-10"
                                    style={{ backgroundColor: "#c1272d" }}
                                >
                                    -
                                    {Math.round(
                                        100 -
                                            (item.descuento * 100) / item.precio
                                    )}
                                    %
                                </span>
                            </div>
                        )}

                        {item.tags?.map((tag) => (
                            <div className="mb-1" key={tag.id}>
                                <span
                                    className="block font-semibold text-[8px] font-Urbanist_Regular md:text-[12px] bg-black py-1 px-2 flex-initial w-full text-center text-white rounded-none relative z-10"
                                    style={{ backgroundColor: tag.color }}
                                >
                                    {tag.name}
                                </span>
                            </div>
                        ))}
                    </div>
                </div>

                <div>
                    <div className="relative flex justify-center items-center h-max">
                        <a href={`/producto/${item.slug}`}>
                            <img
                                style={{
                                    // opacity: !item.imagen_ambiente || !showAmbiente ? '1' : '0',
                                    // scale: !item.imagen_ambiente || !showAmbiente ? '1.05' : '1',
                                    backgroundColor: "#eeeeee",
                                }}
                                //src={item.imagen ? `/${item.imagen}` : '/images/img/noimagen.jpg'}
                                src={
                                    mainImage
                                        ? `/${mainImage}`
                                        : "/images/img/noimagen.jpg"
                                }
                                alt={item.name}
                                onError={(e) =>
                                    (e.target.src = "/images/img/noimagen.jpg")
                                }
                                className={`transition ease-out duration-300 transform w-full aspect-square object-cover inset-0`}
                            />
                        </a>
                    </div>
                </div>
            </div>

            <div className="flex flex-col items-start justify-start h-[120px]">
                <div className="flex justify-start items-center mt-2 gap-1">
                    <Tippy content={item.color}>
                        <a
                            key={item.color}
                            id={`producto-${item.id}-${item.imagen}`}
                            className="ring-1 rounded-full p-[2px] ring-transparent hover:ring-[#808080]"
                            onClick={() => handleColorClick(item.imagen)}
                        >
                            <div
                                className="w-4 md:w-[30px] h-4 md:h-[30px] rounded-full overflow-hidden"
                                //style={{ backgroundColor: color.color }}
                            >
                                <img
                                    className="object-contain object-center"
                                    src={
                                        item.imagen
                                            ? `/${item.imagen}`
                                            : "/images/img/noimagen.jpg"
                                    }
                                />
                            </div>
                        </a>
                    </Tippy>
                    {item.colors &&
                        item.colors.length > 0 &&
                        item.colors
                            ?.filter((color) => color.color !== item.color)
                            .map((color) => (
                                <Tippy content={color.color}>
                                    <a
                                        key={color.color}
                                        id={`producto-${item.id}-${color.imagen}`}
                                        className="ring-1 rounded-full p-[2px] ring-transparent hover:ring-[#808080]"
                                        onClick={() =>
                                            handleColorClick(color.imagen)
                                        }
                                    >
                                        <div
                                            className="w-4 md:w-[30px] h-4 md:h-[30px] rounded-full overflow-hidden"
                                            //style={{ backgroundColor: color.color }}
                                        >
                                            <img
                                                className="object-contain object-center"
                                                src={
                                                    color.imagen
                                                        ? `/${color.imagen}`
                                                        : "/images/img/noimagen.jpg"
                                                }
                                            />
                                        </div>
                                    </a>
                                </Tippy>
                            ))}
                </div>

                {marcas && (
                    <div className="flex justify-start items-center mt-0 md:mt-1 h-6 lg:h-7">
                        <img
                            src={`/${marcas.url_image}`}
                            alt={marcas.title}
                            className="h-4 w-auto"
                            onError={(e) =>
                                (e.target.src = "/images/img/noimagen.jpg")
                            }
                        />
                    </div>
                )}

                <a href={`/producto/${item.slug}`} className="p-0">
                    <Tippy content={item.producto}>
                        <h2
                            className="block text-sm xl:text-base text-left overflow-hidden font-medium text-[#808080] font-Urbanist_Regular"
                            style={{
                                display: "-webkit-box",
                                WebkitLineClamp: 1,
                                textOverflow: "ellipsis",
                                WebkitBoxOrient: "vertical",
                                height: "31",
                            }}
                        >
                            {item.producto}
                        </h2>
                    </Tippy>
                    {/* <span className='text-[12px] font-Urbanist_Light'>{item.color} - {item.peso}</span> */}

                    {is_reseller ? (
                        <>
                            <div className="flex content-between flex-row gap-4 items-center justify-start">
                                <span className="text-[#15294C] opacity-60 text-[16.45px]  line-through">
                                    S/.{" "}
                                    {item.descuento > 0
                                        ? item.descuento
                                        : item.precio}
                                </span>
                                {item.descuento > 0 && (
                                    <span className="text-sm text-[#15294C] opacity-60 line-through">
                                        S/. {item.precio}
                                    </span>
                                )}
                            </div>
                            <div className="flex content-between flex-row gap-4 items-center justify-start">
                                Reseller{" "}
                                <span className="text-[#c1272d] text-[16.45px] font-bold">
                                    S/. {item.precio_reseller}
                                </span>
                            </div>
                        </>
                    ) : (
                        <div className="w-full flex content-between flex-row gap-4 items-center justify-start text-left font-Urbanist_Light">
                            <span className="text-[#c1272d] font-Urbanist_Regular font-bold">
                                {item.descuento > 0 ? (
                                    <div className="flex flex-col justify-start items-center">
                                        <span className="text-base lg:text-lg">
                                            S/. {item.descuento}
                                        </span>
                                    </div>
                                ) : (
                                    <div className="flex flex-col justify-start items-center text-lg ">
                                        <span className="font-bold text-base lg:text-lg">
                                            S/. {item.precio}
                                        </span>
                                    </div>
                                )}
                            </span>
                            {item.descuento > 0 && (
                                <>
                                    <div className="flex flex-col items-start">
                                        <span className=" text-[#808080] opacity-80 line-through font-Urbanist_Regular text-[12px] md:text-sm">
                                            {" "}
                                            S/. {item.precio}
                                        </span>
                                    </div>
                                </>
                            )}
                        </div>
                    )}
                </a>
            </div>
        </div>
    );
};

export default ProductCard;

{
    /* <div className="addProduct text-center flex justify-center h-0">
    <div className='flex flex-row gap-2 items-center'>
      <a
        href={`/producto/${item.slug}`}
        className="font-semibold text-[16px] bg-[#c1272d] py-2 px-4 text-center text-white rounded-3xl h-10"
      >
        Ver producto
      </a>
      <Tippy content="Agregar al Carrito">
        <button href={`/producto/${item.slug}`} type="button" id='btnAgregarCarrito'
          data-id={`${item.id}`}
          className="flex items-center font-semibold text-[13px] bg-[#c1272d] py-1 px-4 text-center text-white rounded-3xl h-10">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="22" height="22" fill="#FFFFFF" ><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96zM252 160c0 11 9 20 20 20l44 0 0 44c0 11 9 20 20 20s20-9 20-20l0-44 44 0c11 0 20-9 20-20s-9-20-20-20l-44 0 0-44c0-11-9-20-20-20s-20 9-20 20l0 44-44 0c-11 0-20 9-20 20z" /></s
        </button>
      </Tippy>
    </div>
  </div> */
}
