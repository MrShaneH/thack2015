using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace HotelService
{
    public class HotelSearchRequest
    {
        public string Longitude { get; set; }
        public string Latitude { get; set; }
        public int Radius { get; set; }
        public DateTime StartDate { get; set; }
    }
}
