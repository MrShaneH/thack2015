using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HotelService
{
    public interface IHotelService
    {
        HotelSearchResponse Search(HotelSearchRequest hotelSearchRequest);
    }
}
