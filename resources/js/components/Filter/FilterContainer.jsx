import React from 'react'
import FilterItem from './FilterItem'

const FilterContainer = ({ minPrice, maxPrice, brands = [], sizes = [], colors = [] }) => {
  return (<>
    <button className="w-full h-12 text-[15px] bg-slate-100 text-center font-medium rounded-lg" type="reset">
      Limpiar filtros
    </button>

    <FilterItem title="Precio" className="flex flex-row gap-4 w-full">
      <input type="number" className="w-28 rounded-md border" placeholder="Desde" min={minPrice} max={maxPrice} step={0.01} />
      <input type="number" className="w-28 rounded-md border" placeholder="Hasta" min={minPrice} max={maxPrice} step={0.01} />
    </FilterItem>
    {
      brands.length > 0 &&
      <FilterItem title="Marca" items={brands} itemName='valor' />
    }
    {
      colors.length > 0 &&
      <FilterItem title="Color" items={colors} itemName='valor' />
    }
    {
      sizes.length > 0 &&
      <FilterItem title="Tamaño" items={sizes} itemName='valor' />
    }
    <button className="text-white bg-[#0168EE] rounded-md font-bold h-10 w-24" type="submit">
      Filtrar
    </button>
  </>)
}

export default FilterContainer