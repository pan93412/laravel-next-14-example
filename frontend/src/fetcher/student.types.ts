import z from "zod";

export type Student = z.infer<typeof StudentSchema>;
export const StudentSchema = z.object({
  id: z.string(),
  name: z.string(),
  addr: z.string(),
  birth: z.string().pipe(z.coerce.date()),
});

export type Students = z.infer<typeof StudentsSchema>;
export const StudentsSchema = z.array(StudentSchema);

export type StudentRequestDto = {
  name: string;
  addr: string;
  birth: string;
};

export type StudentDeleteDto = {
  id: string;
};

export type StudentPUpdateDto = {
  name?: string | undefined;
  addr?: string | undefined;
  birth?: string | undefined;
};
