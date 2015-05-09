using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HotelService
{
    public class HotelStay
    {
        public int HotelId { get; set; }
        public string LocationName { get; set; }
        public string Longitude { get; set; }
        public string Latitude { get; set; }
        public decimal Price { get; set; }
    }
}
